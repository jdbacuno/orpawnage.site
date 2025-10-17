<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnimalAbuseReport;
use App\Notifications\AbuseReportAcknowledged;
use App\Notifications\AbuseReportReceived;
use App\Notifications\AbuseReportRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnimalAbuseReportController extends Controller
{
    public function index(Request $request)
    {
        $query = AnimalAbuseReport::query();

        // Exclude archived reports by default
        if ($request->status !== 'archived') {
            $query->where('status', '!=', 'archived');
        }

        // Status Filter
        $status = $request->status;
        $search = $request->search;
        switch ($status) {
            case 'pending':
                $query->where('status', 'pending');
                break;

            case 'action taken':
                $query->where('status', 'action taken');
                break;

            case 'rejected':
                $query->where('status', 'rejected');
                break;

            default:
                // No status filter - show all
                break;
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%$search%")
                    ->orWhere('full_name', 'like', "%$search%")
                    ->orWhere('contact_no', 'like', "%$search%")
                ;
            });
        }

        // Sorting
        if ($request->has('sort') && in_array($request->sort, ['incident_date'])) {
            $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }

        $reports = $query->paginate(12)
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
            // Valid ID: 5MB max
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
            // Incident photos: max 10 files, 5MB each
            'incident_photos' => ['required', 'array', 'max:5'],
            'incident_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ]);

        // Add custom validation for total upload size (50MB limit for abuse reports)
        $validator->after(function ($validator) use ($request) {
            $totalSize = 0;

            if ($request->hasFile('valid_id')) {
                $totalSize += $request->file('valid_id')->getSize();
            }

            if ($request->hasFile('incident_photos')) {
                foreach ($request->file('incident_photos') as $photo) {
                    $totalSize += $photo->getSize();
                }
            }

            // 50MB total limit (50 * 1024 * 1024 bytes) - higher for abuse reports
            if ($totalSize > 26214400) {
                $validator->errors()->add('files', 'Total file size cannot exceed 25MB.');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $validated['user_id'] = Auth::id();
        $validated['report_number'] = $this->generateUniqueReportNumber();

        // Upload Valid ID
        if ($request->hasFile('valid_id')) {
            $validIdFile = $request->file('valid_id');
            $validIdName = "valid_id_{$validated['report_number']}." . $validIdFile->getClientOriginalExtension();
            $validated['valid_id_path'] = $validIdFile->storeAs('abuse_report_valid_ids', $validIdName, 'public');

            // Remove the file object from validated data
            unset($validated['valid_id']);
        }

        // Upload Incident Photos
        $incidentPhotos = [];
        if ($request->hasFile('incident_photos')) {
            foreach ($request->file('incident_photos') as $index => $photo) {
                $photoName = "incident_photo_{$validated['report_number']}_{$index}." . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('incident_photos', $photoName, 'public');
                $incidentPhotos[] = $path;
            }

            // Remove the files array from validated data
            unset($validated['incident_photos']);
        }

        $validated['incident_photos'] = json_encode($incidentPhotos);
        $validated['status'] = 'pending';

        $report = AnimalAbuseReport::create($validated);
        $report->user->notify(new AbuseReportReceived($report));

        return redirect()->back()->with('success', 'Report submitted successfully! Kindly await for an email update or visit the ' . '<a href="/transactions/abused-status" class="text-blue-500">Transactions' . "</a>" . ' page to track your application.');
    }

    public function acknowledge(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:animal_abuse_reports,id']
        ]);

        $report = AnimalAbuseReport::findOrFail($request->report_id);
        $report->update(['status' => 'action taken']);

        try {
            $report->user->notify(new AbuseReportAcknowledged($report));
            return redirect()->back()
                ->with('success', 'Report #' . $report->report_number . ' has been acknowledged and user notified.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Report acknowledged but failed to send notification.');
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:animal_abuse_reports,id'],
            'reject_reason' => ['required', 'string']
        ]);

        $report = AnimalAbuseReport::findOrFail($request->report_id);
        $report->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason
        ]);

        try {
            $report->user->notify(new AbuseReportRejected($report));
            return redirect()->back()
                ->with('success', 'Report has been rejected and user notified.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Report rejected but failed to send notification.');
        }
    }

    public function destroy(AnimalAbuseReport $abusedReport)
    {
        // Delete the associated valid ID if it exists
        if ($abusedReport->valid_id_path) {
            Storage::disk('public')->delete($abusedReport->valid_id_path);
        }

        // Delete all incident photos
        if ($abusedReport->incident_photos) {
            foreach (json_decode($abusedReport->incident_photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
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

    public function archive(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:animal_abuse_reports,id'
        ]);

        $report = AnimalAbuseReport::findOrFail($request->report_id);

        if ($report->status !== 'action taken' && $report->status !== 'rejected') {
            return redirect()->back()->with('error', 'Only reports with action taken or rejected status can be archived.');
        }

        $report->update([
            'previous_status' => $report->status,
            'status' => 'archived'
        ]);

        return redirect()->back()->with('success', 'Report has been archived.');
    }
}
