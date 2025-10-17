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
    public function create()
    {
        $query = Pet::whereNull('archived_at') // Only non-archived pets
            ->whereNotIn('id', function ($subQuery) {
                $subQuery->select('pet_id')
                    ->from('adoption_applications')
                    ->whereIn('status', ['to be scheduled', 'adoption on-going', 'picked up']); // Exclude pets with these statuses
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
                            $q->whereIn('status', ['to be confirmed', 'confirmed', 'to be scheduled', 'rejected']);
                        });
                });
            } elseif ($status === 'in_process') {
                $query->whereHas('adoptionApplication', function ($q) {
                    $q->whereIn('status', ['to be confirmed', 'confirmed', 'to be scheduled']);
                });
            }
        }

        // Apply sorting (default to newest arrivals)
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
            // Default sorting: newest arrivals
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
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:0.1', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/'],
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
            'image' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:10240'],
        ], [
            'age.regex' => 'Age must be a valid number with up to 2 decimal places.',
            'age.numeric' => 'Age must be a valid number.',
            'age.min' => 'Age must be at least 0.1.',
            'age.max' => 'Age cannot be more than 100.',
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

        // Handle breed - set to null if empty
        $validated['breed'] = !empty(trim($validated['breed'] ?? ''))
            ? trim($validated['breed'])
            : null;

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
            'breed' => ['nullable', 'string', 'max:255'],
            'age' => ['required', 'numeric', 'min:0.1', 'max:100', 'regex:/^\d+(\.\d{1,2})?$/'],
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
        ], [
            'age.regex' => 'Age must be a valid number with up to 2 decimal places.',
            'age.numeric' => 'Age must be a valid number.',
            'age.min' => 'Age must be at least 0.1.',
            'age.max' => 'Age cannot be more than 100.',
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

        // Handle breed - set to null if empty
        $validated['breed'] = !empty(trim($validated['breed'] ?? ''))
            ? trim($validated['breed'])
            : null;

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

        // Archive the pet
        $pet->update([
            'archive_reason' => $request->archive_reason,
            'archive_notes' => $request->archive_notes,
            'archived_at' => now(),
        ]);

        // Get all pending applications for this pet
        $pendingApplications = \App\Models\AdoptionApplication::where('pet_id', $pet->id)
            ->whereIn('status', ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption on-going'])
            ->get();

        $rejectedCount = 0;

        foreach ($pendingApplications as $application) {
            // Determine rejection reason based on archive reason
            $rejectReason = $request->archive_reason === 'Pet has passed away'
                ? 'The pet has passed away and is no longer available for adoption.'
                : 'The pet is no longer available for adoption as it has been archived.';

            $application->update([
                'status' => 'rejected',
                'reject_reason' => $rejectReason,
            ]);

            // Send rejection notification to applicant
            $application->user->notify(new \App\Notifications\AdoptionStatusNotification($application->id));

            $rejectedCount++;
        }

        $successMessage = $rejectedCount > 0
            ? "Pet archived successfully. {$rejectedCount} pending application(s) have been rejected and notifications sent."
            : "Pet archived successfully.";

        return back()->with('success', $successMessage);
    }
}
