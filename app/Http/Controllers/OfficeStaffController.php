<?php

namespace App\Http\Controllers;

use App\Models\OfficeStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficeStaffController extends Controller
{
    public function index(Request $request)
    {
        $query = OfficeStaff::query()->orderBy('order');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%");
            });
        }

        $staff = $query->paginate(12);
        return view('admin.office-staff', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handle image upload or use default
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('staff-images', 'public');
        } else {
            // Copy default image to storage with unique name
            $defaultImage = 'images/profile_pic.png';
            $newFilename = 'staff-' . uniqid() . '.png';
            Storage::disk('public')->put(
                'staff-images/' . $newFilename,
                file_get_contents(public_path($defaultImage))
            );
            $imagePath = 'staff-images/' . $newFilename;
        }

        $staff = OfficeStaff::create([
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
            'image_path' => $imagePath,
            'order' => OfficeStaff::max('order') + 1,
        ]);

        return back()->with('success', 'Staff member added successfully!');
    }

    public function update(Request $request, OfficeStaff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'position' => $request->position,
            'email' => $request->email,
        ];

        if ($request->hasFile('image')) {
            try {
                // Store new image first
                $newPath = $request->file('image')->store('staff-images', 'public');
                $data['image_path'] = $newPath;

                // Then safely delete old image if it exists and isn't a default image
                if ($staff->image_path && !str_contains($staff->image_path, 'profile_pic.png')) {
                    if (Storage::disk('public')->exists($staff->image_path)) {
                        Storage::disk('public')->delete($staff->image_path);
                    } else {
                        // Fallback: try deleting via public path if stored path got prefixed elsewhere
                        $publicPath = public_path('storage/' . ltrim($staff->image_path, '/'));
                        if (is_file($publicPath)) {
                            @unlink($publicPath);
                        }
                    }
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to update image: ' . $e->getMessage());
            }
        } elseif (!$staff->image_path) {
            // Only set default image if no image exists at all
            $defaultImage = 'images/profile_pic.png';
            $newFilename = 'staff-' . uniqid() . '.png';
            Storage::disk('public')->put(
                'staff-images/' . $newFilename,
                file_get_contents(public_path($defaultImage))
            );
            $data['image_path'] = 'staff-images/' . $newFilename;
        }

        $staff->update($data);

        return back()->with('success', 'Staff member updated successfully!');
    }

    public function destroy(OfficeStaff $staff)
    {
        try {
            // Only delete the image if it exists and isn't the default profile image
            if ($staff->image_path && !str_contains($staff->image_path, 'profile_pic.png')) {
                if (Storage::disk('public')->exists($staff->image_path)) {
                    Storage::disk('public')->delete($staff->image_path);
                } else {
                    $publicPath = public_path('storage/' . ltrim($staff->image_path, '/'));
                    if (is_file($publicPath)) {
                        @unlink($publicPath);
                    }
                }
            }

            $staff->delete();

            return back()->with('success', 'Staff member deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete staff member: ' . $e->getMessage());
        }
    }

    public function updateOrder(Request $request, OfficeStaff $staff)
    {
        $request->validate([
            'order' => 'required|integer',
        ]);

        $staff->update(['order' => $request->order]);

        return back()->with('success', 'Order updated!');
    }
}
