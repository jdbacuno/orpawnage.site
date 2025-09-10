<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\User;
use App\Notifications\NewPetAdded;
use App\Notifications\PetArchivedNotification;
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
        $query = Pet::whereNull('archived_at') // Only non-archived pets
            ->whereNotIn('id', function ($subQuery) {
                $subQuery->select('pet_id')
                    ->from('adoption_applications')
                    ->whereIn('status', ['picked up', 'archived']); // Exclude pets with picked up OR archived adoption apps
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
                    $q->whereIn('status', ['to be confirmed', 'confirmed', 'adoption on-going', 'to be scheduled']);
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
            $query->orderByRaw("
            (CASE 
                WHEN age_unit = 'years' THEN age * 12 
                WHEN age_unit = 'months' THEN age 
                ELSE 0 
            END) ASC
        ");
            $query->orderBy('created_at', 'desc');
        }

        $perPage = request()->get('per_page', 8); // Use 8 as default if not provided
        $pets = $query->paginate($perPage)->appends(request()->query());

        return view('admin.pets', compact('pets'));
    }

    public function store(Request $request)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1', 'max:100'],
            'pet_name' => ['nullable', 'string'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'age' => ['required', 'integer', 'min:1', 'max:100'],
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
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_open', 'add');
        }

        $validated = $validator->validated();

        // Set default pet name if empty or null
        $validated['pet_name'] = trim($validated['pet_name'] ?? '') !== ''
            ? $validated['pet_name']
            : 'N/A';

        // Normalize common variations like "n/a", "na"
        if (in_array(strtolower($validated['pet_name']), ['n/a', 'na'])) {
            $validated['pet_name'] = 'N/A';
        }

        // Upload image
        if ($request->hasFile('image')) {
            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->file('image')->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']); // Remove image field before saving

        $pet = Pet::create($validated);

        // Notify users (non-admins)
        User::whereNotNull('email_verified_at')
            ->whereNotNull('email')
            ->chunk(100, function ($users) use ($pet) {
                Notification::send($users, new NewPetAdded($pet));
            });

        return redirect()->back()->with([
            'add_success' => '<a class="text-blue-500" target="_blank" href="/services/' . $pet->slug . '/adoption-form">#' . $pet->pet_number . '</a>',
            'modal_open' => null,
        ]);
    }


    public function update(Request $request, Pet $pet)
    {
        // Validate the request manually
        $validator = Validator::make($request->all(), [
            'pet_number' => ['required', 'integer', 'min:1', 'max:100'],
            'pet_name' => ['nullable', 'string'],
            'species' => ['required', Rule::in(['feline', 'canine'])],
            'age' => ['required', 'integer', 'min:1', 'max:100'],
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
            'image' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'edit_pet')
                ->withInput()
                ->with([
                    'modal_open' => 'edit',
                    'edit_pet_id' => $pet->id
                ]);
        }

        $validated = $validator->validated();

        // Set default pet name if empty or null
        $validated['pet_name'] = trim($validated['pet_name'] ?? '') !== ''
            ? $validated['pet_name']
            : 'N/A';

        // Normalize "n/a" or similar entries
        if (in_array(strtolower($validated['pet_name']), ['n/a', 'na'])) {
            $validated['pet_name'] = 'N/A';
        }

        // Handle image upload and deletion
        if ($request->hasFile('image')) {
            if ($pet->image_path && Storage::disk('public')->exists($pet->image_path)) {
                Storage::disk('public')->delete($pet->image_path);
            }

            $timestamp = now()->format('YmdHis');
            $extension = $request->image->getClientOriginalExtension();
            $imageFileName = "pet{$validated['pet_number']}_{$timestamp}.{$extension}";
            $imagePath = $request->file('image')->storeAs('pet-images', $imageFileName, 'public');

            $validated['image_path'] = $imagePath;
        }

        unset($validated['image']); // Remove the file object before updating

        $pet->update($validated);

        return redirect()->to(url()->previous())
            ->with([
                'edit_pet_id' => $pet->id,
                'edit_success' => '<a target="_blank" class="text-blue-500" href="/services/' . $pet->slug . '/adoption-form">#' . $validated['pet_number'] . '</a>',
                'modal_open' => null,
            ]);
    }


    public function archive(Request $request, Pet $pet)
    {
        $validator = Validator::make($request->all(), [
            'archive_reason' => ['required', 'string', 'max:255'],
            'archive_notes' => [
                Rule::requiredIf(fn() => $request->archive_reason === 'Other'),
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('archive_pet_number', $pet->pet_number);
        }

        $pet->update([
            'archive_reason' => $request->archive_reason,
            'archive_notes' => $request->archive_notes,
            'archived_at' => now(),
        ]);

        User::chunk(100, function ($users) use ($pet) {
            Notification::send($users, new PetArchivedNotification($pet));
        });

        return back()->with('success', 'Pet archived successfully.');
    }
}
