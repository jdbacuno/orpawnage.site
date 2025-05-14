<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MissingPetReport;
use App\Models\User;
use App\Notifications\MissingPetAlert;
use App\Notifications\MissingPetReportAcknowledged;
use App\Notifications\MissingPetReportReceived;
use App\Notifications\MissingPetReportRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MissingPetReportController extends Controller
{
    public function index(Request $request)
    {
        $query = MissingPetReport::query();

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
        if ($request->has('sort') && in_array($request->sort, ['last_seen_date'])) {
            $direction = $request->get('direction', 'asc') === 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort, $direction);
        } else {
            $query->latest();
        }

        $reports = $query->paginate(10)
            ->appends($request->query());

        return view('admin.missing-pet-reports', compact('reports'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => ['required', 'string', 'max:255'],
            'contact_no' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'pet_name' => ['required', 'string', 'max:255'],
            'last_seen_location' => ['required', 'string'],
            'last_seen_date' => ['required', 'date', 'before_or_equal:today'],
            'pet_description' => ['required', 'string'],
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:10240'],
            'pet_photos' => ['required', 'array', 'max:5'],
            'pet_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
            'location_photos' => ['nullable', 'array', 'max:5'],
            'location_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg', 'max:10240'],
        ]);

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
            $validated['valid_id_path'] = $validIdFile->storeAs('missing_pet_valid_ids', $validIdName, 'public');

            // Remove the file object from validated data
            unset($validated['valid_id']);
        }

        // Upload Pet Photos
        $petPhotos = [];
        if ($request->hasFile('pet_photos')) {
            foreach ($request->file('pet_photos') as $index => $photo) {
                $photoName = "pet_photo_{$validated['report_number']}_{$index}." . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('missing_pet_photos', $photoName, 'public');
                $petPhotos[] = $path;
            }

            // Remove the files array from validated data
            unset($validated['pet_photos']);
        }
        $validated['pet_photos'] = json_encode($petPhotos);

        // Upload Location Photos
        $locationPhotos = [];
        if ($request->hasFile('location_photos')) {
            foreach ($request->file('location_photos') as $index => $photo) {
                $photoName = "location_photo_{$validated['report_number']}_{$index}." . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('missing_pet_location_photos', $photoName, 'public');
                $locationPhotos[] = $path;
            }

            // Remove the files array from validated data
            unset($validated['location_photos']);
        }
        $validated['location_photos'] = json_encode($locationPhotos);
        $validated['status'] = 'pending';

        $report = MissingPetReport::create($validated);

        $report->user->notify(new MissingPetReportReceived($report));

        return redirect()->back()->with('success', 'Missing pet report submitted successfully! Kindly await for an email update or visit the ' . '<a href="/transactions/missing-status" class="text-blue-500">Transactions' . "</a>" . ' page to track your application.');
    }

    public function acknowledge(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:missing_pet_reports,id']
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);
        $report->update(['status' => 'acknowledged']);

        try {
            // First, notify the reporter that their report has been acknowledged
            $report->user->notify(new MissingPetReportAcknowledged($report));

            // Then, send the missing pet alert to all users
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new MissingPetAlert($report));
            }

            // Alternatively, you can use the Notification facade to send to multiple users at once:
            // Notification::send($users, new MissingPetAlert($report));

            return redirect()->back()
                ->with('success', 'Report #' . $report->report_number . ' has been acknowledged. The reporter has been notified and missing pet alerts have been sent to all users.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Report acknowledged but failed to send notifications: ' . $e->getMessage());
        }
    }

    public function reject(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:missing_pet_reports,id'],
            'reject_reason' => ['required', 'string']
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);
        $report->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason
        ]);

        try {
            $report->user->notify(new MissingPetReportRejected($report));
            return redirect()->back()
                ->with('success', 'Report has been rejected and user notified.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Report rejected but failed to send notification.');
        }
    }

    public function destroy(MissingPetReport $missingReport)
    {
        // Delete the associated valid ID if it exists
        if ($missingReport->valid_id_path) {
            Storage::disk('public')->delete($missingReport->valid_id_path);
        }

        // Delete all pet photos
        if ($missingReport->pet_photos) {
            foreach (json_decode($missingReport->pet_photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        // Delete all location photos
        if ($missingReport->location_photos) {
            foreach (json_decode($missingReport->location_photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $missingReport->delete();

        return redirect()->back()
            ->with('success', 'Missing pet report has been deleted successfully.');
    }

    private function generateUniqueReportNumber()
    {
        do {
            $date = now()->format('Ymd');
            $random = strtoupper(Str::random(3)) . rand(100, 999);
            $reportNumber = "MPR{$date}{$random}";
        } while (MissingPetReport::where('report_number', $reportNumber)->exists());

        return $reportNumber;
    }
}
