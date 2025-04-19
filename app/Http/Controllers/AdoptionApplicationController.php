<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\ArchivedAdoptionApplication;
use App\Models\Pet;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdoptionApplicationController extends Controller
{
    public function index()
    {
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');
        $status = request('status');

        $allowedSorts = ['created_at', 'pet_number', 'species', 'age', 'sex', 'color', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $activeQuery = AdoptionApplication::with(['pet', 'user']);
        $archivedQuery = ArchivedAdoptionApplication::with('pet');

        if ($status === 'active') {
            $activeQuery->whereIn('status', ['pending', 'to be scheduled', 'to be picked up']);
            $archivedQuery = collect();
        } elseif ($status && $status !== 'all') {
            $activeQuery->where('status', $status);
            $archivedQuery = collect();
        } else {
            $activeQuery->whereIn('status', ['pending', 'to be scheduled', 'to be picked up', 'picked up', 'rejected']);
        }

        $active = $activeQuery->get()->map(function ($item) {
            $item->is_archived = false;
            return $item;
        });

        if ($archivedQuery instanceof \Illuminate\Database\Eloquent\Builder) {
            $archived = $archivedQuery->get()->map(function ($item) {
                $item->is_archived = true;
                $item->status = 'picked up';
                $item->created_at = $item->adopted_at ?? $item->created_at;
                $item->birthdate = Carbon::parse($item->birthdate);
                $item->user = null;
                return $item;
            });
        } else {
            $archived = $archivedQuery;
        }

        $merged = $active->merge($archived)->sortBy(function ($item) use ($sort) {
            return $item->$sort ?? $item->created_at;
        }, SORT_REGULAR, $direction === 'desc');

        $perPage = 9;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $merged->forPage($currentPage, $perPage),
            $merged->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.adoption-applications', ['adoptionApplications' => $paginated]);
    }

    public function create(Pet $pet)
    {
        return view('adoption-form', compact('pet'));
    }

    public function store(Request $request, Pet $pet)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'age' => ['required', 'integer', 'min:18'],
            'birthdate' => ['required', 'date', 'after_or_equal:1900-01-01', 'before_or_equal:2099-12-31'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'address' => ['required', 'string', 'max:500'],
            'civil_status' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Keeps validation errors separate
                ->withInput()
                ->with('submission_error', 'Failed to submit application. Please check the form for errors.');
        }

        // Check if the pet has already been requested for adoption (excluding rejected ones)
        if (AdoptionApplication::where('pet_id', $pet->id)
            ->where('status', '!=', 'rejected')
            ->exists()
        ) {
            return back()->with('error_request', 'This pet has already been requested for adoption.');
        }


        // Normalize input fields
        $validated = $validator->validated();
        $validated['full_name'] = ucwords(trim($validated['full_name']));
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['address'] = ucfirst(trim($validated['address']));
        $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
        $validated['citizenship'] = ucfirst(trim($validated['citizenship']));

        $validated['transaction_number'] = $this->generateUniqueTransactionNumber();

        // Create the adoption application
        AdoptionApplication::create([
            'user_id' => Auth::id(),
            'pet_id' => $pet->id,
            ...$validated,
        ]);

        return back()->with('success', 'Adoption application submitted successfully! Kindly await for an email update or visit the ' . '<a href="/transactions/adoption-status" class="text-blue-500">Transactions' . "</a>" . ' page to track your application.');
    }

    public function approve(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id'],
            'pickup_date' => [
                'required',
                'date',
                'after_or_equal:tomorrow',
                'before_or_equal:' . now()->addDays(7)->toDateString()
            ],
        ]);

        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        // Store the original pickup date before update
        $oldPickupDate = $application->pickup_date;

        $application->update([
            'pickup_date' => $request->pickup_date,
            'status' => 'to be picked up',
        ]);

        // Send approval or reschedule notification with old pickup date
        $application->user->notify(new AdoptionStatusNotification($application, $oldPickupDate));

        return redirect('/admin/adoption-applications')->with('success', 'Pickup date scheduled successfully.');
    }

    public function markAsPickedUp(Request $request)
    {
        $application = AdoptionApplication::with(['user', 'pet'])->findOrFail($request->application_id);

        if ($application->status !== 'to be picked up') {
            return redirect()->back()->with('error', 'Invalid status change.');
        }

        $application->update([
            'status' => 'picked up',
        ]);

        // Send pickup confirmation notification
        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Adoption marked as picked up.');
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

        // Send rejection notification
        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Adoption application rejected.');
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
}
