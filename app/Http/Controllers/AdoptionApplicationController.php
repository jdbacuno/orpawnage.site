<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Notifications\AdoptionStatusNotification;
use App\Notifications\PetAdoptionAnnouncement;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Notification;

class AdoptionApplicationController extends Controller
{
    const APPLICATION_LIMIT = 20;

    public function index()
    {
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
        $status = request('status');
        $search = request('search');

        $query = AdoptionApplication::with(['pet', 'user'])
            ->where('status', '!=', 'archived'); // Exclude archived applications by default

        if ($status && $status !== '') {
            // Handle specific status filter
            if (is_array($status)) {
                $query->whereIn('status', $status);
            } else {
                $query->where('status', $status);
            }

            // Get filtered applications
            $applications = $query->get();

            // Group by pet and sort (only for status filters)
            $grouped = $applications->groupBy('pet_id')->map(function ($applications) {
                return $applications->sortBy(function ($app) {
                    $statusOrder = [
                        'to be confirmed' => 1,
                        'confirmed' => 2,
                        'to be scheduled' => 3,
                        'adoption on-going' => 4,
                        'picked up' => 5,
                        'rejected' => 6,
                    ];

                    $order = $statusOrder[$app->status] ?? 7;

                    // Boost priority for Angeles City residents in confirmed status
                    if ($app->status === 'confirmed' && stripos($app->address, 'angeles') !== false) {
                        $order = 1.5;
                    }

                    return $order;
                })->values();
            });

            // Flatten back to collection for pagination
            $flatApplications = $grouped->flatten(1);
        } else {
            // For "all applications" (no status filter) - ungrouped version
            $query->whereIn('status', [
                'to be confirmed',
                'confirmed',
                'to be scheduled',
                'adoption on-going',
                'picked up',
                'rejected'
            ]);

            // Apply sorting for ungrouped version
            $sort = request('sort', 'created_at');
            $direction = request('direction', 'desc');

            $flatApplications = $query->orderBy($sort, $direction)->get();
        }

        if ($search) {
            $flatApplications = $flatApplications->filter(function ($app) use ($search) {
                return stripos($app->transaction_number, $search) !== false ||
                    stripos($app->email, $search) !== false ||
                    stripos($app->full_name, $search) !== false;
            });
        }

        // Manual pagination
        $perPage = request()->get('per_page', 12);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $flatApplications->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $applications = new LengthAwarePaginator(
            $currentItems,
            $flatApplications->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Append query parameters to pagination links
        $applications->appends(request()->query());

        return view('admin.adoption-applications', [
            'adoptionApplications' => $applications
        ]);
    }

    public function create(Pet $pet)
    {
        $isPetArchived = $pet->archived_at !== null;

        $hasPendingApplication = AdoptionApplication::where('user_id', Auth::id())
            ->whereIn('status', ['to be confirmed', 'confirmed', 'adoption on-going', 'to be scheduled'])
            ->exists();

        // Check if pet has reached application limit (excluding archived and rejected)
        $applicationCount = AdoptionApplication::where('pet_id', $pet->id)
            ->whereNotIn('status', ['archived', 'rejected'])
            ->count();

        $applicationLimitReached = $applicationCount >= self::APPLICATION_LIMIT;

        return view('adoption-form', [
            'pet' => $pet,
            'hasPendingApplication' => $hasPendingApplication,
            'applicationLimitReached' => $applicationLimitReached,
            'isPetArchived' => $isPetArchived
        ]);
    }

    public function store(Request $request, Pet $pet)
    {
        // Check if user has any pending/ongoing applications
        $existingApplication = AdoptionApplication::where('user_id', Auth::id())
            ->whereIn('status', ['to be confirmed', 'confirmed', 'adoption on-going', 'to be scheduled'])
            ->first();

        if ($existingApplication) {
            return back()->with(
                'error_request',
                'You already have a pending adoption application (Transaction #' . $existingApplication->transaction_number . '). ' .
                    'Please wait until your current application is completed or rejected before submitting a new one. ' .
                    'You may also cancel the on-going application to be able to submit an adoption request for a different pet.'
            );
        }

        // Check if pet has reached application limit (excluding archived and rejected)
        $applicationCount = AdoptionApplication::where('pet_id', $pet->id)
            ->whereNotIn('status', ['archived', 'rejected'])
            ->count();

        if ($applicationCount >= self::APPLICATION_LIMIT) {
            return back()->with(
                'error_request',
                'This pet is no longer accepting applications at the moment. The maximum number of applications has been reached. In the meantime, please browse other available pets for adoption.'
            );
        }

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'age' => ['required', 'integer', 'min:18'],
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:today',
                function ($attribute, $value, $fail) use ($request) {
                    $birthdate = new DateTime($value);
                    $today = new DateTime();
                    $age = $today->diff($birthdate)->y;
                    if ($age != $request->age) {
                        $fail('The age does not match the birthdate provided.');
                    }
                }
            ],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'address' => ['required', 'string', 'max:500'],
            'civil_status' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
            'reason_for_adoption' => ['required', 'string', 'max:1000'],
            'visit_veterinarian' => ['required', 'string', 'in:Yes,No,Sometimes'],
            'existing_pets' => ['required', 'integer', 'min:0'],
            // Valid ID: 5MB max
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
        }

        // Check if pet is no longer available for adoption
        if (AdoptionApplication::where('pet_id', $pet->id)
            ->whereIn('status', ['adoption on-going', 'picked up'])
            ->exists()
        ) {
            return back()->with('error_request', 'This pet is no longer available for adoption.');
        }

        // Check if pet has been archived
        if ($pet->archived_at !== null) {
            return back()->with('error_request', 'This pet is no longer available for adoption.');
        }

        $validated = $validator->validated();

        $validated['full_name'] = ucwords(strtolower(trim($validated['full_name'])));
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['address'] = ucfirst(trim($validated['address']));
        $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
        $validated['citizenship'] = ucfirst(strtolower(trim($validated['citizenship'])));
        $validated['reason_for_adoption'] = trim($validated['reason_for_adoption']);
        $validated['transaction_number'] = $this->generateUniqueTransactionNumber();

        // Upload valid ID
        $extension = $request->valid_id->getClientOriginalExtension();
        $filename = str_replace(' ', '_', $validated['email']) . '_' . $validated['transaction_number'] . '.' . $extension;
        $validIdPath = $request->file('valid_id')->storeAs('valid_ids', $filename, 'public');
        $validated['valid_id'] = $validIdPath;

        $application = AdoptionApplication::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            ...$validated,
        ]);

        $application->user->notify(new AdoptionStatusNotification($application->id));

        return back()->with(
            'success',
            'Adoption application submitted successfully! Please check your email to confirm your application within 24 hours. ' .
                'You can visit the <a href="/transactions/adoption-status" class="text-blue-500">Transactions</a> ' .
                'page to track your application. You may resend the confirmation email if you did not receive it.'
        );
    }

    public function confirmApplication($application)
    {
        $application = AdoptionApplication::where('id', $application)
            ->where('status', 'to be confirmed')
            ->first();

        if (!$application) {
            return response()->view('confirmation-result', [
                'success' => false,
                'message' => 'Invalid or already confirmed application.'
            ]);
        }

        if ($application->created_at->diffInHours(now()) > 24) {
            // Auto-reject expired applications
            $application->update([
                'status' => 'rejected',
                'reject_reason' => 'Application expired - not confirmed within 24 hours'
            ]);

            return response()->view('confirmation-result', [
                'success' => false,
                'message' => 'This confirmation link has expired. Please submit a new application.'
            ]);
        }

        // Update the application status to confirmed
        $application->update(['status' => 'confirmed']);

        // Send confirmation notification
        $application->user->notify(new AdoptionStatusNotification($application->id));

        return response()->view('confirmation-result', [
            'success' => true,
            'message' => 'Your adoption application has been successfully confirmed!',
            'type' => 'adoption'
        ]);
    }

    public function moveToSchedule(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id']
        ]);

        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        // Update status to 'to be scheduled'
        $application->update(['status' => 'to be scheduled']);

        // Reject only confirmed or to be confirmed applications (not already rejected ones)
        $otherApplications = AdoptionApplication::where('pet_id', $application->pet_id)
            ->where('id', '!=', $application->id)
            ->whereIn('status', ['confirmed', 'to be confirmed'])
            ->get();

        $rejectedCount = 0;
        foreach ($otherApplications as $otherApp) {
            $otherApp->update([
                'status' => 'rejected',
                'reject_reason' => 'Another applicant has been selected to move forward with the adoption process.'
            ]);

            // Send rejection email only to newly rejected applicants
            $otherApp->user->notify(new AdoptionStatusNotification($otherApp->id));
            $rejectedCount++;
        }

        // Send email to selected applicant with scheduling information
        $application->user->notify(new AdoptionStatusNotification($application->id));

        $message = $rejectedCount > 0
            ? "Application moved to scheduling for visitation. Emails have been sent to the selected applicant and {$rejectedCount} other applicant(s)."
            : "Application moved to scheduling visitation. Email has been sent to the selected applicant.";

        return redirect()->back()->with('success', $message);
    }

    public function markAsPickedUp(Request $request)
    {
        $application = AdoptionApplication::with(['pet', 'user'])->findOrFail($request->application_id);

        if ($application->status !== 'adoption on-going') {
            return redirect()->back()->with('error', 'Invalid status change.');
        }

        $application->update(['status' => 'picked up', 'pickup_date' => now()]);

        // Send email to adopter
        $application->user->notify(new AdoptionStatusNotification($application->id));

        // Send general announcement to all users (including admins) in chunks
        \App\Models\User::where('id', '!=', $application->user_id)
            ->chunkById(500, function ($users) use ($application) {
                Notification::send($users, new PetAdoptionAnnouncement($application->pet));
            });

        return redirect()->back()->with('success', 'Adoption marked as completed and notifications sent.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id'],
            'reject_reason' => ['required', 'string', 'max:500'],
        ]);

        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        $application->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

        $application->user->notify(new AdoptionStatusNotification($application->id));

        return redirect()->back()->with('success', 'Adoption application rejected.');
    }

    public function archive(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:adoption_applications,id'
        ]);

        $application = AdoptionApplication::findOrFail($request->application_id);

        if (!in_array($application->status, ['picked up', 'rejected'])) {
            return redirect()->back()->with('error', 'Only completed or rejected adoptions can be archived.');
        }

        $application->update([
            'previous_status' => $application->status,
            'status' => 'archived'
        ]);

        return redirect()->back()->with('success', 'Adoption application archived.');
    }

    private function generateUniqueTransactionNumber()
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(3)) . rand(100, 999);
            $transactionNumber = "AP{$date}{$random}";
        } while (AdoptionApplication::where('transaction_number', $transactionNumber)->exists());

        return $transactionNumber;
    }

    public function resendEmail($id)
    {
        $application = AdoptionApplication::findOrFail($id);

        // Resend confirmation email
        $application->user->notify(new AdoptionStatusNotification($application->id));

        return back()->with('success', 'Confirmation email resent successfully.');
    }

    public function schedulePickup(Request $request, $id)
    {
        $application = AdoptionApplication::findOrFail($id);

        $validated = $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today'
        ]);

        $pickupDate = Carbon::parse($validated['pickup_date']);

        // Build 7 business day window
        $start = Carbon::now();
        $end = $start->copy();
        $businessDays = 0;

        while ($businessDays < 7) {
            if (!$end->isWeekend()) {
                $businessDays++;
            }
            if ($businessDays < 7) {
                $end->addDay();
            }
        }

        if ($pickupDate->gt($end) || $pickupDate->isWeekend()) {
            return redirect()->back()->withErrors([
                'pickup_date' => 'Date must be a weekday within 7 business days.'
            ]);
        }

        $application->pickup_date = $pickupDate;
        $application->status = 'adoption on-going';
        $application->save();

        $application->user->notify(new AdoptionStatusNotification($application->id));

        return redirect()->back()->with('success', 'Visitation scheduled successfully!');
    }

    public function destroy(AdoptionApplication $application)
    {
        // Delete the associated photo if it exists
        if ($application->valid_id) {
            Storage::disk('public')->delete($application->valid_id);
        }

        $application->delete();

        return redirect()->back()->with('success', 'Adoption request deleted successfully.');
    }
}
