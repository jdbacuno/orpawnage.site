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
            $subQuery->select('pet_id')
                ->from('adoption_applications')
                ->whereNotIn('status', ['rejected']); // Exclude only non-rejected applications
        });

        // Apply filters
        if ($request->filled('species')) {
            $query->where('species', $request->species);
        }

        if ($request->filled('sex')) {
            $query->where('sex', $request->sex);
        }

        if ($request->filled('reproductive_status')) {
            $query->where('reproductive_status', $request->reproductive_status);
        }

        if ($request->filled('color')) {
            $query->where('color', $request->color);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
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
                    WHEN age_unit = 'years' THEN age * 12 * 4  
                    WHEN age_unit = 'months' THEN age * 4     
                    WHEN age_unit = 'weeks' THEN age           
                    ELSE 0 
                END) DESC
            ");
                    break;
                case 'youngest':
                default:
                    $query->orderByRaw("
                (CASE 
                    WHEN age_unit = 'years' THEN age * 12 * 4  
                    WHEN age_unit = 'months' THEN age * 4     
                    WHEN age_unit = 'weeks' THEN age            
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
                WHEN age_unit = 'years' THEN age * 12 * 4  
                WHEN age_unit = 'months' THEN age * 4      
                WHEN age_unit = 'weeks' THEN age            
                ELSE 0 
            END $sortDirection");
            } else {
                $query->orderBy($sortField, $sortDirection);
            }
        } else {
            // Default sorting: recently added first
            $query->orderBy('created_at', 'desc');
        }

        $pets = $query->paginate(10)->appends(request()->query());

        return view('admin.pets', compact('pets'));
    }

    public function store(Request $request)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'age' => ['required', 'integer', 'min:1'],
            'age_unit' => ['required', Rule::in(['months', 'years'])],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'reproductive_status' => ['required', Rule::in(['intact', 'neutered', 'unknown'])],
            'color' => ['required', Rule::in([
                'black',
                'white',
                'gray',
                'brown',
                'orange',
                'brindle',
                'calico',
                'tabby',
                'bi-color',
                'tri-color',
                'others'
            ])],
            'source' => ['required', Rule::in(['surrendered', 'rescued', 'other'])],
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_open', 'add'); // Keep modal open on error
        }

        // Normalize case for specific fields
        $validated = $validator->validated();

        // Upload Image
        if ($request->hasFile('image')) {
            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->file('image')->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']); // Remove 'image' field before saving

        // Create and store the pet
        $pet = Pet::create($validated); // 🔥 FIX: Assign the created pet to a variable

        return redirect()->back()->with([
            'add_success' => '<a class="text-blue-500" href="/services/' . $pet->slug . '/adoption-form">#' . $pet->pet_number . '</a>',
            'modal_open' => null // Keep modal open on success
        ]);
    }

    public function update(Request $request, Pet $pet)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'age' => ['required', 'integer', 'min:1'],
            'age_unit' => ['required', Rule::in(['months', 'years', 'weeks'])],
            'sex' => ['required', Rule::in(['male', 'female'])],
            'reproductive_status' => ['required', Rule::in(['intact', 'neutered', 'unknown'])],
            'color' => ['required', Rule::in([
                'black',
                'white',
                'gray',
                'brown',
                'orange',
                'brindle',
                'calico',
                'tabby',
                'bi-color',
                'tri-color',
                'others'
            ])],
            'source' => ['required', Rule::in(['surrendered', 'rescued', 'other'])],
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],  // Changed to 'file' and added 'svg' mime
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
            $imagePath = $request->file('image')->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        // Remove 'image' field before updating the database
        unset($validated['image']);

        // Update the pet record
        $pet->update($validated);

        return redirect()->to(url()->previous()) // Redirect to the previous page
            ->with([
                'edit_pet_id' => $pet->id,
                'edit_success' => '<a class="text-blue-500" href="/services/' . $pet->slug . '/adoption-form">#' . $validated['pet_number'] . '</a>',
                'modal_open' => null, // Close the modal
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

        return redirect('/admin/pet-profiles')->with([
            'delete_success' => "Pet #{$pet->pet_number} has been deleted!",
            'modal_open' => null, // Close the modal
        ]);
    }
}
