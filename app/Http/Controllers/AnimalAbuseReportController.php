<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AbuseReportAcknowledged;
use App\Mail\AbuseReportRejected;
use App\Models\AnimalAbuseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnimalAbuseReportController extends Controller
{
    public function index(Request $request)
    {
        $query = AnimalAbuseReport::query();

        // Status Filter
        $status = $request->status;
        switch ($status) {
            case 'pending':
                $query->where('status', 'pending');
                break;

            case 'acknowledged':
                $query->where('status', 'acknowledged');
                break;

            case 'rejected':
                $query->where('status', 'rejected');
                break;

            default:
                // No status filter - show all
                break;
        }

        // Sorting
        if ($request->has('sort') && in_array($request->sort, ['incident_date'])) {
            $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }

        $reports = $query->paginate(10)
            ->appends($request->query());

        return view('admin.abused-stray-reports', compact('reports'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['nullable', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'incident_location' => ['required', 'string'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'species' => ['required', 'string'],
            'animal_condition' => ['required', 'string'],
            'additional_notes' => ['required', 'string'],
            'incident_photo' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Add user_id and report_number to validated data
        $validated['user_id'] = Auth::id();
        $validated['report_number'] = $this->generateUniqueReportNumber();

        // Determine filename based on full_name or auth username
        $fileNameBase = $validated['full_name'] ?? Auth::user()->name;

        // Replace spaces with underscores if full_name exists
        if ($validated['full_name']) {
            $fileNameBase = str_replace(' ', '_', $fileNameBase);
            $fileNameBase = strtolower($fileNameBase);
        }

        $timestamp = now()->format('YmdHis');
        $extension = $request->file('incident_photo')->getClientOriginalExtension();
        $fileName = "{$validated['report_number']}_abuse_report_{$timestamp}.{$extension}";

        // Upload and rename photo
        if ($request->hasFile('incident_photo')) {
            $validated['incident_photo'] = $request->file('incident_photo')
                ->storeAs('incident_photos', $fileName, 'public');
        }

        // Create the report and store in the database
        AnimalAbuseReport::create($validated);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }

    public function acknowledge(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:animal_abuse_reports,id'],
            'status' => ['required', 'in:acknowledged'],
        ]);

        $report = AnimalAbuseReport::findOrFail($request->report_id);

        // Send email to the user who reported
        Mail::to($report->user->email)->send(new AbuseReportAcknowledged($report));
        $report->update(['status' => 'acknowledged']);


        return redirect()->back()
            ->with('success', 'Report #' . '<strong>' . $report->report_number . '</strong>' . ' has been acknowledged and user notified via email.');
    }

    public function reject(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:animal_abuse_reports,id'],
            'status' => ['required', 'in:rejected']
        ]);

        $report = AnimalAbuseReport::findOrFail($request->report_id);

        // Send email to the user who reported
        Mail::to($report->user->email)->send(new AbuseReportRejected($report));
        $report->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', 'Report has been rejected successfully.');
    }

    public function destroy(AnimalAbuseReport $abusedReport)
    {
        // Delete the associated photo if it exists
        if ($abusedReport->incident_photo) {
            Storage::disk('public')->delete($abusedReport->incident_photo);
        }

        $abusedReport->delete();

        return redirect()->back()
            ->with('success', 'Report has been deleted successfully.');
    }

    private function generateUniqueReportNumber()
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(3)) . rand(100, 999);
            $reportNumber = "RAS{$date}{$random}";
        } while (AnimalAbuseReport::where('report_number', $reportNumber)->exists());

        return $reportNumber;
    }
}
