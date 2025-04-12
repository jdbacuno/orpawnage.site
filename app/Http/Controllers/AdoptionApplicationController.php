<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdoptionApplicationController extends Controller
{
    public function index()
    {
        // Default sorting: newest first (created_at desc)
        $sort = request('sort', 'created_at');
        $direction = request('direction', 'desc');

        // Ensure only valid columns are used to prevent SQL injection
        $allowedSorts = ['created_at', 'pet_number', 'species', 'age', 'sex', 'color', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $query = AdoptionApplication::with(['pet', 'user']);

        // Status Filter - default is 'picked up'
        if (request()->filled('status')) {
            $status = request('status');
            if ($status === 'active') {
                $query->whereIn('status', ['to be scheduled', 'to be picked up']);
            } elseif ($status === 'all') {
                // No status filter applied
            } else {
                $query->where('status', $status);
            }
        }

        $adoptionApplications = $query->orderBy($sort, $direction)
            ->paginate(9);

        return view('admin.adoption-applications', compact('adoptionApplications'));
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

        return back()->with('success', 'Adoption application submitted successfully!');
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


        $application = AdoptionApplication::findOrFail($request->application_id);
        $application->update([
            'pickup_date' => $request->pickup_date,
            'status' => 'to be picked up',
        ]);

        return redirect('/admin/adoption-applications')->with('success', 'Pickup date scheduled successfully.');
    }

    public function markAsPickedUp(Request $request)
    {
        $application = AdoptionApplication::findOrFail($request->application_id);

        if ($application->status !== 'to be picked up') {
            return redirect()->back()->with('error', 'Invalid status change.');
        }

        $application->update([
            'status' => 'picked up',
        ]);

        return redirect()->back()->with('success', 'Adoption marked as picked up.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'application_id' => ['required', 'exists:adoption_applications,id'],
            'reject_reason' => ['required', 'string', 'max:500'],
        ]);

        $application = AdoptionApplication::findOrFail($request->application_id);

        // Update status and store the reason
        $application->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason,
        ]);

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
