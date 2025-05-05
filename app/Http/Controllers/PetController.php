<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Notifications\NewPetAdded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PetController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = Pet::whereNotIn('id', function ($subQuery) {
    //         $subQuery->select('pet_id')
    //             ->from('adoption_applications')
    //             ->whereNotIn('status', ['rejected']); // Exclude only non-rejected applications
    //     });

    //     // Apply filters
    //     if ($request->filled('species')) {
    //         $query->where('species', $request->species);
    //     }

    //     if ($request->filled('sex')) {
    //         $query->where('sex', $request->sex);
    //     }

    //     if ($request->filled('reproductive_status')) {
    //         $query->where('reproductive_status', $request->reproductive_status);
    //     }

    //     if ($request->filled('color')) {
    //         $query->where('color', $request->color);
    //     }

    //     if ($request->filled('source')) {
    //         $query->where('source', $request->source);
    //     }

    //     // Default sorting when first visiting the page
    //     if (!$request->filled('sort_by')) {
    //         $query->orderByRaw("
    //         (CASE 
    //             WHEN age_unit = 'years' THEN age * 12 
    //             WHEN age_unit = 'months' THEN age 
    //             ELSE 0 
    //         END) ASC
    //     ");
    //         $query->orderBy('created_at', 'desc'); // Newest pets first if same age
    //     }

    //     // Sorting based on selection
    //     if ($request->filled('sort_by')) {
    //         switch ($request->sort_by) {
    //             case 'oldest':
    //                 $query->orderBy('created_at', 'asc');
    //                 break;
    //             case 'latest':
    //                 $query->orderBy('created_at', 'desc');
    //                 break;
    //             case 'oldest_age':
    //                 $query->orderByRaw("
    //             (CASE 
    //                 WHEN age_unit = 'years' THEN age * 12 * 4  
    //                 WHEN age_unit = 'months' THEN age * 4     
    //                 WHEN age_unit = 'weeks' THEN age           
    //                 ELSE 0 
    //             END) DESC
    //         ");
    //                 break;
    //             case 'youngest':
    //             default:
    //                 $query->orderByRaw("
    //             (CASE 
    //                 WHEN age_unit = 'years' THEN age * 12 * 4  
    //                 WHEN age_unit = 'months' THEN age * 4     
    //                 WHEN age_unit = 'weeks' THEN age            
    //                 ELSE 0 
    //             END) ASC
    //         ");
    //                 break;
    //         }
    //     }

    //     $pets = $query->paginate(8)->appends($request->query());

    //     if ($request->ajax()) {
    //         $pet = $pets->fresh();
    //         $html = view('partials.pet-cards', compact('pets'))->render();
    //         $pagination = $pets->appends($request->except('page'))->links()->toHtml();

    //         return response()->json([
    //             'html' => $html,
    //             'pagination' => $pagination
    //         ]);
    //     }

    //     return view('adopt-a-pet', compact('pets'));
    // }

    public function create()
    {
        $query = Pet::whereNotIn('id', function ($subQuery) {
            $subQuery->select('pet_id')
                ->from('adoption_applications')
                ->where('status', 'picked up'); // Exclude pets that have been picked up
        });

        // Apply filters
        if (request()->filled('species')) {
            $query->where('species', request('species'));
        }

        if (request()->filled('sex')) {
            $query->where('sex', request('sex'));
        }

        if (request()->filled('reproductive_status')) {
            $query->where('reproductive_status', request('reproductive_status'));
        }

        if (request()->filled('color')) {
            $query->where('color', request('color'));
        }

        if (request()->filled('source')) {
            $query->where('source', request('source'));
        }

        // Adoption Status Filter
        if (request()->filled('adoption_status')) {
            $status = request('adoption_status');
            if ($status === 'available') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('adoptionApplication')
                        ->orWhereHas('adoptionApplication', function ($q) {
                            $q->where('status', 'rejected')
                                ->orWhereNull('status');
                        });
                });
            } elseif ($status === 'in_process') {
                $query->whereHas('adoptionApplication', function ($q) {
                    $q->whereIn('status', ['to be picked up', 'to be scheduled']);
                });
            }
        }

        // Apply sorting
        if (request()->filled('sort_by')) {
            switch (request('sort_by')) {
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'youngest':
                    $query->orderByRaw("
                    CASE 
                        WHEN age_unit = 'years' THEN age * 12 * 4  
                        WHEN age_unit = 'months' THEN age * 4      
                        WHEN age_unit = 'weeks' THEN age            
                        ELSE 0 
                    END ASC
                ");
                    break;
                case 'oldest_age':
                    $query->orderByRaw("
                    CASE 
                        WHEN age_unit = 'years' THEN age * 12 * 4  
                        WHEN age_unit = 'months' THEN age * 4      
                        WHEN age_unit = 'weeks' THEN age            
                        ELSE 0 
                    END DESC
                ");
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sorting when first visiting the page
            if (!request()->filled('sort_by')) {
                $query->orderByRaw("
            (CASE 
                WHEN age_unit = 'years' THEN age * 12 
                WHEN age_unit = 'months' THEN age 
                ELSE 0 
            END) ASC
        ");
                $query->orderBy('created_at', 'desc'); // Newest pets first if same age
            }
        }

        $pets = $query->paginate(8)->appends(request()->query());

        return view('admin.pets', compact('pets'));
    }

    public function store(Request $request)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'pet_name' => ['required', 'string'],
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

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_open', 'add'); // Keep modal open on error
        }

        // Normalize case for specific fields
        $validated = $validator->validated();

        // If pet name is 'n/a', convert it to 'N/A'
        if (strtolower($validated['pet_name']) == 'n/a') {
            $validated['pet_name'] = 'N/A';
        }

        // Upload the image
        if ($request->hasFile('image')) {
            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->file('image')->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']); // Remove the image field from validation data

        // Create and store the pet
        $pet = Pet::create($validated);

        // Notify all users except admins asynchronously
        User::whereNotNull('email_verified_at')
            ->whereNotNull('email') // Optional, just in case
            ->chunk(100, function ($users) use ($pet) {
                Notification::send($users, new NewPetAdded($pet));
            });


        // Return success response
        return redirect()->back()->with([
            'add_success' => '<a class="text-blue-500" target="_blank" href="/services/' . $pet->slug . '/adoption-form">#' . $pet->pet_number . '</a>',
            'modal_open' => null // Close modal on success
        ]);
    }

    public function update(Request $request, Pet $pet)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1'],
            'pet_name' => ['required', 'string'],
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

        if (strtolower($validated['pet_name']) == 'n/a') {
            $validated['pet_name'] = 'N/A';
        }

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
                'edit_success' => '<a target="_blank" class="text-blue-500" href="/services/' . $pet->slug . '/adoption-form">#' . $validated['pet_number'] . '</a>',
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
