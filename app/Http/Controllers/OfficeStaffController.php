<?php

namespace App\Http\Controllers;

use App\Models\OfficeStaff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfficeStaffController extends Controller
{
    // OfficeStaffController.php
    public function index()
    {
        $staff = OfficeStaff::orderBy('is_featured', 'desc')
            ->orderBy('order')
            ->get();
        return view('admin.office-staff', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('staff-images', 'public');
        }

        $staff = OfficeStaff::create([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'image_path' => $imagePath,
            'is_featured' => $request->boolean('is_featured'),
            'order' => OfficeStaff::max('order') + 1
        ]);

        return redirect()->back()->with('add_success', $staff->name);
    }

    public function update(Request $request, OfficeStaff $officeStaff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($officeStaff->image_path) {
                Storage::disk('public')->delete($officeStaff->image_path);
            }
            $officeStaff->image_path = $request->file('image')->store('staff-images', 'public');
        }

        $officeStaff->update([
            'name' => $validated['name'],
            'position' => $validated['position'],
            'is_featured' => $request->boolean('is_featured')
        ]);

        return redirect()->back()->with('edit_success', $officeStaff->name);
    }

    public function destroy(OfficeStaff $officeStaff)
    {
        if ($officeStaff->image_path) {
            Storage::disk('public')->delete($officeStaff->image_path);
        }
        $officeStaff->delete();
        return redirect()->back()->with('delete_success', 'Staff member deleted successfully!');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $order => $id) {
            OfficeStaff::where('id', $id)->update(['order' => $order]);
        }
        return response()->json(['success' => true]);
    }
}
