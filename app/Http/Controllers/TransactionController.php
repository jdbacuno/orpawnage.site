<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AnimalAbuseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function adoption(Request $request)
    {
        $status = $request->get('status');
        $userId = Auth::id();

        $query = AdoptionApplication::with('pet')->where('user_id', $userId);

        if ($status && in_array($status, ['to be confirmed', 'confirmed', 'to be picked up', 'to be scheduled', 'picked up', 'rejected'])) {
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

            case 'acknowledged':
                $query->where('status', 'acknowledged');
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
