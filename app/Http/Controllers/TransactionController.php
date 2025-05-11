<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AnimalAbuseReport;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function adoption(Request $request)
    {
        $status = $request->get('status');
        $userId = Auth::id();

        $query = AdoptionApplication::with('pet')->where('user_id', $userId);

        if ($status && in_array($status, ['to be confirmed', 'confirmed', 'to be picked up', 'adoption on-going', 'to be scheduled', 'picked up', 'rejected', 'archive'])) {
            $query->where('status', $status);
        }

        $applications = $query->orderByRaw("
            CASE status
                WHEN 'to be picked up' THEN 0
                WHEN 'to be scheduled' THEN 1
                WHEN 'confirmed' THEN 2
                WHEN 'to be confirmed' THEN 3
                WHEN 'picked up' THEN 4
                ELSE 3
            END
        ")->latest()->paginate(9);

        return view('transactions.adoptions', [
            'adoptionApplications' => $applications,
            'status' => $status,
        ]);
    }

    public function surrender(Request $request)
    {
        // Similar structure for surrender applications
        $userId = Auth::id();
        $applications = []; // Replace with your actual query

        return view('transactions.surrender', [
            'applications' => $applications,
        ]);
    }

    public function missing(Request $request)
    {
        // Similar structure for missing pet reports
        $userId = Auth::id();
        $applications = []; // Replace with your actual query

        return view('transactions.missing', [
            'applications' => $applications,
        ]);
    }

    public function abused(Request $request)
    {
        $userId = Auth::id();
        $status = $request->get('status');

        $query = AnimalAbuseReport::where('user_id', $userId);

        // Separate queries for each status
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
                // No additional filtering for 'all' or empty status
                break;
        }

        $reports = $query->latest()->paginate(9);

        return view('transactions.abused', [
            'abusedReports' => $reports,
            'status' => $status,
        ]);
    }

    public function resendEmail($id)
    {
        $application = AdoptionApplication::findOrFail($id);

        // Logic to send email...
        $application->user->notify(new AdoptionStatusNotification($application));

        return back()->with('success', 'Confirmation email resent successfully.');
    }

    public function schedulePickup(Request $request, $id)
    {
        $application = AdoptionApplication::findOrFail($id);

        $validated = $request->validate([
            'pickup_date' => 'required|date|after_or_equal:today'
        ]);

        $pickupDate = Carbon::parse($validated['pickup_date']);

        // Build 7 business day window (including today if not weekend)
        $start = Carbon::now();
        $end = $start->copy();
        $businessDays = 0;
        while ($businessDays < 7) {
            if (!$end->isWeekend()) $businessDays++;
            if ($businessDays < 7) $end->addDay();
        }

        if ($pickupDate->gt($end) || $pickupDate->isWeekend()) {
            return redirect()->back()->withErrors(['pickup_date' => 'Date must be a weekday within 7 business days.']);
        }

        $application->pickup_date = $pickupDate;
        $application->status = 'adoption on-going';
        $application->save();

        $application->user->notify(new AdoptionStatusNotification($application));

        return redirect()->back()->with('success', 'Pickup scheduled successfully!');
    }

    public function destroy(AdoptionApplication $application)
    {
        // Delete the associated photo if it exists
        if ($application->valid_id) {
            Storage::disk('public')->delete($application->valid_id);
        }

        $application->delete();

        return redirect()->back()->with('success', 'Adoption request deleted successfully.');
    }
}
