<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdoptionApplicationController extends Controller
{
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
}
