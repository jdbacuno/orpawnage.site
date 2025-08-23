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
        ]);

        $bugReport = new BugReport();
        $bugReport->description = $request->description;
        $bugReport->page_url = $request->page_url;
        $bugReport->user_agent = $request->user_agent;
        $bugReport->status = 'pending';

        if (Auth::check()) {
            $bugReport->user_id = Auth::id();
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

    public function index()
    {
        $bugReports = BugReport::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

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
