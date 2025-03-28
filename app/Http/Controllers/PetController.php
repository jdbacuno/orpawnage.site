<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PetController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::whereNotIn('id', function ($subQuery) {
            $subQuery->select('pet_id')->from('adoption_applications');
        });

        // Apply filters
        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        // Default sorting when first visiting the page
        if (!$request->filled('sort_by')) {
            $query->orderByRaw("
            (CASE 
                WHEN age_unit = 'years' THEN age * 12 
                WHEN age_unit = 'months' THEN age 
                ELSE 0 
            END) ASC
        ");
            $query->orderBy('created_at', 'desc'); // Newest pets first if same age
        }

        // Sorting based on selection
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest_age':
                    $query->orderByRaw("
                    (CASE 
                        WHEN age_unit = 'years' THEN age * 12 
                        WHEN age_unit = 'months' THEN age 
                        ELSE 0 
                    END) DESC
                ");
                    break;
                case 'youngest':
                default:
                    $query->orderByRaw("
                    (CASE 
                        WHEN age_unit = 'years' THEN age * 12 
                        WHEN age_unit = 'months' THEN age 
                        ELSE 0 
                    END) ASC
                ");
                    break;
            }
        }

        $pets = $query->paginate(8)->appends($request->query());

        return view('adopt-a-pet', compact('pets'));
    }


    public function create()
    {
        $query = Pet::query();

        // Apply sorting
        if (request()->has('sort')) {
            $sortField = request('sort');
            $sortDirection = request('direction') === 'asc' ? 'asc' : 'desc';

            // Special case for sorting by age (considering age unit)
            if ($sortField === 'age') {
                $query->orderByRaw("CASE 
                WHEN age_unit = 'years' THEN age * 12
                ELSE age
            END $sortDirection");
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        } else {
            // Default sorting: youngest first, then recently added
            $query->orderByRaw("CASE 
            WHEN age_unit = 'years' THEN age * 12
            ELSE age
        END ASC")->orderBy('created_at', 'desc');
        }

        $pets = $query->paginate(5)->appends(request()->query());

        return view('admin.pets', compact('pets'));
    }


    public function store(Request $request)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'breed' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0'],
            'age_unit' => ['required', Rule::in(['months', 'years'])],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'color' => ['required', Rule::in([
                'black',
                'white',
                'gray',
                'brown',
                'orange',
                'calico',
                'tabby',
                'bi-color',
                'tri-color',
                'others'
            ])],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_open', 'add'); // Keep modal open on error
        }

        // Normalize case for specific fields
        $validated = $validator->validated();
        $validated['species'] = strtolower(trim($validated['species']));
        $validated['breed'] = strtolower(trim($validated['breed']));
        $validated['color'] = strtolower(trim($validated['color']));

        // Upload Image
        if ($request->hasFile('image')) {
            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->image->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']); // Remove 'image' field before saving

        // Insert the data into the database
        Pet::create($validated);

        return redirect()->back()->with([
            'add_success' => 'Pet added successfully!',
            'modal_open' => 'add' // Keep modal open on success
        ]);
    }

    public function update(Request $request, Pet $pet)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'breed' => ['required', 'string'],
            'age' => ['required', 'integer', 'min:0'],
            'age_unit' => ['required', Rule::in(['months', 'years'])],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'color' => ['required', Rule::in([
                'black',
                'white',
                'gray',
                'brown',
                'orange',
                'calico',
                'tabby',
                'bi-color',
                'tri-color',
                'others'
            ])],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
        ]);

        // If validation fails, redirect with errors under 'edit_pet' bag
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'edit_pet')
                ->withInput()
                ->with([
                    'modal_open' => 'edit',
                    'edit_pet_id' => $pet->id  // Pass pet ID to prefill modal correctly
                ]);
        }

        // Normalize case for specific fields
        $validated = $validator->validated();
        $validated['species'] = strtolower(trim($validated['species']));
        $validated['breed'] = strtolower(trim($validated['breed']));
        $validated['color'] = strtolower(trim($validated['color']));

        // Handle Image Upload & Deletion
        if ($request->hasFile('image')) {
            // Delete existing image if it exists
            if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
                Storage::disk('public')->delete($pet->image_path);
            }

            // Store new image
            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->image->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        // Remove 'image' field before updating the database
        unset($validated['image']);

        // Update the pet record
        $pet->update($validated);

        return redirect('/admin/pet-profiles')
            ->with([
                'modal_open' => 'edit',
                'edit_pet_id' => $pet->id, // Ensure the modal remains open for the same pet
                'edit_pet_data' => $pet->fresh(), // Pass fresh updated data for correct repopulation
                'edit_success' => 'Pet updated successfully!'
            ]);
    }

    public function destroy(Pet $pet)
    {
        // Delete pet image if exists
        if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
            Storage::disk('public')->delete($pet->image_path);
        }

        // Delete pet record
        $pet->delete();

        return redirect('/admin/pet-profiles')->with('success', 'Pet deleted successfully!');
    }
}
