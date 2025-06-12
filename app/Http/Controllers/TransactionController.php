<?php

namespace App\Http\Controllers;

use App\Models\AdoptionApplication;
use App\Models\AnimalAbuseReport;
use App\Models\MissingPetReport;
use App\Models\SurrenderApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $perPage = request()->get('per_page', 12);

        $applications = $query->orderByRaw("
            CASE status
                WHEN 'to be picked up' THEN 0
                WHEN 'to be scheduled' THEN 1
                WHEN 'confirmed' THEN 2
                WHEN 'to be confirmed' THEN 3
                WHEN 'picked up' THEN 4
                ELSE 3
            END
        ")->latest()->paginate($perPage);

        return view('transactions.adoptions', [
            'adoptionApplications' => $applications,
            'status' => $status,
        ]);
    }

    public function surrender(Request $request)
    {
        $status = $request->get('status');
        $userId = Auth::id();

        $query = SurrenderApplication::where('user_id', $userId);

        if ($status && in_array($status, ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender on-going', 'completed', 'rejected'])) {
            $query->where('status', $status);
        }

        $perPage = request()->get('per_page', 12);

        $applications = $query->orderByRaw("
        CASE status
            WHEN 'surrender on-going' THEN 0
            WHEN 'to be scheduled' THEN 1
            WHEN 'confirmed' THEN 2
            WHEN 'to be confirmed' THEN 3
            WHEN 'completed' THEN 4
            ELSE 3
        END
    ")->latest()->paginate($perPage);

        return view('transactions.surrender', [
            'applications' => $applications,
            'status' => $status,
        ]);
    }

    public function missing(Request $request)
    {
        $userId = Auth::id();
        $status = $request->get('status');

        $query = MissingPetReport::where('user_id', $userId);

        // Status filter
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

        $perPage = request()->get('per_page', 12);
        $reports = $query->latest()->paginate($perPage);

        return view('transactions.missing', [
            'missingReports' => $reports,
            'status' => $status,
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

        $perPage = request()->get('per_page', 12);
        $reports = $query->latest()->paginate($perPage);

        return view('transactions.abused', [
            'abusedReports' => $reports,
            'status' => $status,
        ]);
    }
}
