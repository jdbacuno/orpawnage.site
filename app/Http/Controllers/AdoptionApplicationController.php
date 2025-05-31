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

class AdoptionApplicationController extends Controller
{
    public function index()
    {
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
        $status = request('status');

        $query = AdoptionApplication::with(['pet', 'user'])
            ->where('status', '!=', 'archived') // Exclude archived applications by default
            ->orderBy($sort, $direction);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $perPage = request()->get('per_page', 16);
        $applications = $query->paginate($perPage);

        return view('admin.adoption-applications', ['adoptionApplications' => $applications]);
    }

    public function create(Pet $pet)
    {
        $hasPendingApplication = AdoptionApplication::where('user_id', Auth::id())
            ->whereIn('status', ['to be confirmed', 'confirmed', 'adoption on-going', 'to be scheduled'])
            ->exists();

        return view('adoption-form', [
            'pet' => $pet,
            'hasPendingApplication' => $hasPendingApplication
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
                    'Please wait until your current application is completed or rejected before submitting a new one. You may also cancel the on-going application to be able to submit an adoption request for a different pet.'
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
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
        }

        // Check if pet is already adopted or has pending applications
        if ($pet->is_adopted) {
            return back()->with('error_request', 'This pet has already been adopted.');
        }

        if (AdoptionApplication::where('pet_id', $pet->id)
            ->where('status', '!=', 'rejected')
            ->exists()
        ) {
            return back()->with('error_request', 'This pet has already been requested for adoption.');
        }

        $validated = $validator->validated();
        $validated['full_name'] = ucwords(strtolower(trim($validated['full_name'])));
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['address'] = ucfirst(trim($validated['address']));
        $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
        $validated['citizenship'] = ucfirst(strtolower(trim($validated['citizenship'])));
        $validated['reason_for_adoption'] = ucfirst(trim($validated['reason_for_adoption']));
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

        $application->user->notify(new AdoptionStatusNotification($application));

        return back()->with(
            'success',
            'Adoption application submitted successfully! Please check your email to confirm your application within 24 hours. You can visit the ' . '<a href="/transactions/adoption-status" class="text-blue-500">Transactions' . "</a>" . ' page to track your application. You may resend the confirmation email if you did not receive it.'
        );
    }

    public function confirmApplication($id)
    {
        $application = AdoptionApplication::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'to be confirmed')
            ->first();

        if (!$application) {
            return redirect()->route('transactions.adoption-status')
                ->with('error_request', 'Invalid or already confirmed application.');
        }

        $application->status = 'confirmed';
        $application->save();

        // Notify user that their application has been confirmed
        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->route('transactions.adoption-status')
            ->with('success', 'Your adoption application has been successfully confirmed. A confirmation email has been sent.');
    }

    public function moveToSchedule(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id']
        ]);

        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        // Update status
        $application->update(['status' => 'to be scheduled']);

        // Send email with scheduling link
        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Application moved to scheduling. An email has been sent to the applicant.');
    }

    public function markAsPickedUp(Request $request)
    {
        $application = AdoptionApplication::with(['pet', 'user'])->findOrFail($request->application_id);

        if ($application->status !== 'adoption on-going') {
            return redirect()->back()->with('error', 'Invalid status change.');
        }

        $application->update(['status' => 'picked up', 'pickup_date' => now()]);

        // Send email to adopter
        $application->user->notify(new AdoptionStatusNotification($application));

        // Send general announcement to all users (including admins)
        $users = \App\Models\User::where('id', '!=', $application->user_id)->get();
        foreach ($users as $user) {
            $user->notify(new PetAdoptionAnnouncement($application->pet));
        }

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

        $application->user->notify(new AdoptionStatusNotification($application));

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

        // Logic to send email...
        $application->user->notify(new AdoptionStatusNotification($application));

        return back()->with('success', 'Confirmation email resent successfully.');
    }

    public function schedulePickup(Request $request, $id)
    {
        $application = AdoptionApplication::findOrFail($id);

        $validated = $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today'
        ]);

        $pickupDate = Carbon::parse($validated['pickup_date']);

        // Build 7 business day window (including today if not weekend)
        $start = Carbon::now();
        $end = $start->copy();
        $businessDays = 0;
        while ($businessDays < 7) {
            if (!$end->isWeekend()) $businessDays++;
            if ($businessDays < 7) $end->addDay();
        }

        if ($pickupDate->gt($end) || $pickupDate->isWeekend()) {
            return redirect()->back()->withErrors(['pickup_date' => 'Date must be a weekday within 7 business days.']);
        }

        $application->pickup_date = $pickupDate;
        $application->status = 'adoption on-going';
        $application->save();

        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Pickup scheduled successfully!');
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
