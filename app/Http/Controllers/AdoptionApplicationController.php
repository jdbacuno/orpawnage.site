<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdoptionApplicationController extends Controller
{
    public function index()
    {
        $sort = request('sort', 'created_at'); // Default sorting column
        $direction = request('direction', 'desc'); // Default sorting direction

        // Ensure only valid columns are used to prevent SQL injection
        $allowedSorts = ['created_at', 'pet_number', 'species', 'breed', 'age', 'sex', 'color'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        $adoptionApplications = AdoptionApplication::with(['pet', 'user'])
            ->orderBy($sort, $direction)
            ->paginate(5);

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
            'birthdate' => ['required', 'date'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'address' => ['required', 'string', 'max:500'],
            'civil_status' => ['required', 'string'],
            'citizenship' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the pet has already been requested for adoption
        $existingApplication = AdoptionApplication::where('pet_id', $pet->id)->exists();

        if ($existingApplication) {
            return back()->with('error_request', 'This pet has already been requested for adoption.');
        }

        // Normalize input fields
        $validated = $validator->validated();
        $validated['full_name'] = ucwords(trim($validated['full_name']));
        $validated['email'] = strtolower(trim($validated['email']));
        $validated['address'] = ucfirst(trim($validated['address']));
        $validated['civil_status'] = ucfirst(trim($validated['civil_status']));
        $validated['citizenship'] = ucfirst(trim($validated['citizenship']));

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
            'application_id' => 'required|exists:adoption_applications,id',
            'pickup_date' => 'required|date|after_or_equal:tomorrow|before_or_equal:' . now()->addDays(7)->toDateString(),
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

        return redirect()->route('admin/adoption-applications')->with('success', 'Adoption marked as picked up.');
    }
}
