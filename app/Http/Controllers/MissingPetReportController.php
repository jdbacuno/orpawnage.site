<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MissingPetReport;
use App\Models\User;
use App\Notifications\MissingPetAlert;
use App\Notifications\MissingPetReportApproved;
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
    // Public view for missing pets page
    public function publicIndex()
    {
        $recentPosts = MissingPetReport::where('status', 'approved')
            ->latest('last_reposted_at')
            ->latest('created_at')
            ->take(8)
            ->get();

        return view('missing-form', compact('recentPosts'));
    }

    public function browsePage()
{
    $recentPosts = MissingPetReport::where('status', 'approved')
        ->latest('last_reposted_at')
        ->latest('created_at')
        ->paginate(12);

    return view('missing-pets-browse', compact('recentPosts'));
}

    // User transaction page - view own reports
    public function userIndex(Request $request)
    {
        $query = MissingPetReport::where('user_id', Auth::id());

        // Exclude archived reports
        $query->where('status', '!=', 'archived');

        // Status Filter
        $status = $request->status;
        $search = $request->search;
        
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'found'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%$search%")
                    ->orWhere('pet_name', 'like', "%$search%");
            });
        }

        // Order by last reposted date first, then created date
        $query->latest('last_reposted_at')
              ->latest('created_at');

        $missingReports = $query->paginate(12)->appends($request->query());

        return view('transactions.missing', compact('missingReports'));
    }

    // Admin index
    public function index(Request $request)
    {
        $query = MissingPetReport::query();

        $query->where('status', '!=', 'archived');

        $status = $request->status;
        $search = $request->search;
        
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'found'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%$search%")
                    ->orWhere('owner_name', 'like', "%$search%")
                    ->orWhere('pet_name', 'like', "%$search%")
                    ->orWhere('contact_no', 'like', "%$search%");
            });
        }

        $direction = $request->get('direction', 'desc');
        $query->orderBy('created_at', $direction === 'asc' ? 'asc' : 'desc');

        $reports = $query->paginate(12)->appends($request->query());

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
            'valid_id' => ['required', 'file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
            'pet_photos' => ['required', 'array', 'max:5'],
            'pet_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
            'location_photos' => ['nullable', 'array', 'max:5'],
            'location_photos.*' => ['file', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:5120'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $totalSize = 0;

            if ($request->hasFile('valid_id')) {
                $totalSize += $request->file('valid_id')->getSize();
            }
            if ($request->hasFile('pet_photos')) {
                foreach ($request->file('pet_photos') as $photo) {
                    $totalSize += $photo->getSize();
                }
            }
            if ($request->hasFile('location_photos')) {
                foreach ($request->file('location_photos') as $photo) {
                    $totalSize += $photo->getSize();
                }
            }

            if ($totalSize > 26214400) {
                $validator->errors()->add('files', 'Total file size cannot exceed 25MB.');
            }
        });

        $validated = $validator->validated();
        $validated['user_id'] = Auth::id();
        $validated['report_number'] = $this->generateUniqueReportNumber();

        if ($request->hasFile('valid_id')) {
            $validIdFile = $request->file('valid_id');
            $validIdName = "valid_id_{$validated['report_number']}." . $validIdFile->getClientOriginalExtension();
            $validated['valid_id_path'] = $validIdFile->storeAs('missing_pet_valid_ids', $validIdName, 'public');
            unset($validated['valid_id']);
        }

        $petPhotos = [];
        if ($request->hasFile('pet_photos')) {
            foreach ($request->file('pet_photos') as $index => $photo) {
                $photoName = "pet_photo_{$validated['report_number']}_{$index}." . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('missing_pet_photos', $photoName, 'public');
                $petPhotos[] = $path;
            }
            unset($validated['pet_photos']);
        }
        $validated['pet_photos'] = json_encode($petPhotos);

        $locationPhotos = [];
        if ($request->hasFile('location_photos')) {
            foreach ($request->file('location_photos') as $index => $photo) {
                $photoName = "location_photo_{$validated['report_number']}_{$index}." . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('missing_pet_location_photos', $photoName, 'public');
                $locationPhotos[] = $path;
            }
            unset($validated['location_photos']);
        }
        $validated['location_photos'] = json_encode($locationPhotos);
        $validated['status'] = 'pending';

        $report = MissingPetReport::create($validated);

        $report->user->notify(new MissingPetReportReceived($report));

        return redirect()->back()->with('success', 'Missing pet report submitted successfully! Kindly await for an email update or visit the <a href="/transactions/missing-status" class="text-blue-500 underline">Transactions</a> page to track your report.');
    }

    public function approve(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:missing_pet_reports,id']
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);
        $report->update([
            'status' => 'approved',
            'last_reposted_at' => now()
        ]);

        try {
            $report->user->notify(new MissingPetReportApproved($report));

            User::chunkById(500, function ($users) use ($report) {
                Notification::send($users, new MissingPetAlert($report));
            });

            return redirect()->back()
                ->with('success', 'Report #' . $report->report_number . ' has been approved and posted. Missing pet alerts have been sent to all users.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Report approved but failed to send notifications: ' . $e->getMessage());
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

    public function markAsFound(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:missing_pet_reports,id']
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);
        
        if ($report->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $report->update(['status' => 'found']);

        return redirect()->back()
            ->with('success', 'Your missing pet has been marked as found! Congratulations!');
    }

    public function repost(Request $request)
    {
        $request->validate([
            'report_id' => ['required', 'exists:missing_pet_reports,id']
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);
        
        if ($report->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($report->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved reports can be reposted.');
        }

        $lastReposted = $report->last_reposted_at ?? $report->created_at;
        $daysSince = now()->diffInDays($lastReposted);

        if ($daysSince < 5) {
            $daysRemaining = 5 - $daysSince;
            return redirect()->back()
                ->with('error', "You can repost this report in {$daysRemaining} day(s).");
        }

        $report->update(['last_reposted_at' => now()]);

        return redirect()->back()
            ->with('success', 'Your missing pet report has been reposted to the top!');
    }

    public function destroy(MissingPetReport $missingReport)
    {
        if ($missingReport->valid_id_path) {
            Storage::disk('public')->delete($missingReport->valid_id_path);
        }

        if ($missingReport->pet_photos) {
            foreach (json_decode($missingReport->pet_photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        if ($missingReport->location_photos) {
            foreach (json_decode($missingReport->location_photos) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $missingReport->delete();

        return redirect()->back()
            ->with('success', 'Missing pet report has been deleted successfully.');
    }

    public function archive(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:missing_pet_reports,id'
        ]);

        $report = MissingPetReport::findOrFail($request->report_id);

        if (!in_array($report->status, ['approved', 'rejected', 'found'])) {
            return redirect()->back()->with('error', 'Only approved, rejected, or found reports can be archived.');
        }

        $report->update([
            'previous_status' => $report->status,
            'status' => 'archived'
        ]);

        return redirect()->back()->with('success', 'Missing pet report archived.');
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
