<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BugReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            'screenshot' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'nullable|email|max:255',
        ]);

        $bugReport = new BugReport();
        $bugReport->description = $request->description;
        $bugReport->page_url = $request->page_url;
        $bugReport->user_agent = $request->user_agent;
        $bugReport->status = 'pending';

        if (Auth::check()) {
            $bugReport->user_id = Auth::id();
        } else {
            // If user is not authenticated, store their email if provided
            $bugReport->email = $request->email;
        }

        // Handle screenshot upload
        if ($request->hasFile('screenshot')) {
            $screenshot = $request->file('screenshot');
            $filename = 'bug_report_' . time() . '_' . uniqid() . '.' . $screenshot->getClientOriginalExtension();
            $path = $screenshot->storeAs('bug_reports', $filename, 'public');
            $bugReport->screenshot_path = $path;
        }

        $bugReport->save();

        return response()->json([
            'success' => true,
            'message' => 'Bug report submitted successfully!'
        ]);
    }

    public function index(Request $request)
    {
        $query = BugReport::with('user')
            ->orderBy('created_at', 'desc');

        // Status filter - only apply if a specific status is selected (not empty and not "all")
        if ($request->has('status') && $request->status !== '' && $request->status !== null) {
            $query->where('status', $request->status);
        }
        // If no status is provided or it's empty, show all statuses

        // Search filter
        if ($request->has('search') && $request->search !== '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('description', 'like', "%{$searchTerm}%")
                  ->orWhere('id', 'like', "%{$searchTerm}%")
		  ->orWhere('admin_notes', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('username', 'like', "%{$searchTerm}%");
                  })
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $bugReports = $query->paginate(15);

        return view('admin.bug-reports', compact('bugReports'));
    }

    public function updateStatus(Request $request, BugReport $bugReport)
    {
        Log::info('BugReport updateStatus called', [
            'bug_report_id' => $bugReport->id,
            'request_data' => $request->all(),
            'current_status' => $bugReport->status,
            'current_notes' => $bugReport->admin_notes
        ]);

        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $bugReport->status = $request->status;
        $bugReport->admin_notes = $request->admin_notes;

        if ($request->status === 'resolved') {
            $bugReport->resolved_at = now();
        }

        $bugReport->save();

        Log::info('BugReport updated successfully', [
            'bug_report_id' => $bugReport->id,
            'new_status' => $bugReport->status,
            'new_notes' => $bugReport->admin_notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bug report status updated successfully!'
        ]);
    }

    public function destroy(BugReport $bugReport)
    {
        if ($bugReport->screenshot_path) {
            Storage::disk('public')->delete($bugReport->screenshot_path);
        }

        $bugReport->delete();

        return redirect()->back()->with('success', 'Bug report deleted successfully!');
    }
}
