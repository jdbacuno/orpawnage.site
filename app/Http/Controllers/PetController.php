<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PetController extends Controller
{
    public function create()
    {
        $pets = Pet::latest('updated_at')->paginate(5);
        return view('admin.pets', compact('pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_number' => ['required', 'integer', 'min:1'], // Ensuring pet_number starts from 1
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'breed' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0'],
            'age_unit' => ['required', Rule::in(['months', 'years'])],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'color' => ['required', Rule::in(['black', 'white', 'gray', 'brown', 'orange', 'calico', 'tabby', 'bi-color', 'tri-color', 'others'])],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
        ]);

        // Normalize case for specific fields
        $validated['species'] = strtolower(trim($validated['species']));
        $validated['breed'] = strtolower(trim($validated['breed']));
        $validated['color'] = strtolower(trim($validated['color']));

        // Generate unique image filename
        $timestamp = now()->format('YmdHis');
        $extension = $request->image->getClientOriginalExtension();
        $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";

        // Store the image
        $imagePath = $request->image->storeAs('pet-images', $imageFileName, 'public');

        // Create the pet record in the database
        Pet::create([
            'pet_number' => $validated['pet_number'],
            'species' => $validated['species'],
            'breed' => $validated['breed'],
            'age' => $validated['age'],
            'age_unit' => $validated['age_unit'],
            'sex' => $validated['sex'],
            'color' => $validated['color'],
            'image_path' => $imagePath,
        ]);

        // Return back with success message and keep the modal open
        return redirect()->back()->with([
            'success' => 'Pet added successfully!',
            'modal_open' => true // This can be used in Blade to reopen the modal
        ]);
    }
}
