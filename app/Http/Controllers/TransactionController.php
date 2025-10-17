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
        $search = $request->get('search');

        $query = AdoptionApplication::with('pet')->where('user_id', $userId);

        // Exclude archived applications
        $query->where('status', '!=', 'archived');

        // Status filter
        if ($status && in_array($status, ['to be confirmed', 'confirmed', 'to be scheduled', 'adoption on-going', 'picked up', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('full_name', 'like', "%$search%");
            });
        }

        // Apply sorting - newest first by default
        $direction = $request->get('direction', 'desc');
        $query->orderBy('created_at', $direction === 'asc' ? 'asc' : 'desc');

        $perPage = request()->get('per_page', 12);
        $applications = $query->paginate($perPage)->appends($request->query());

        return view('transactions.adoptions', [
            'adoptionApplications' => $applications,
            'status' => $status,
        ]);
    }

    public function surrender(Request $request)
    {
        $status = $request->get('status');
        $userId = Auth::id();
        $search = $request->get('search');

        $query = SurrenderApplication::where('user_id', $userId);

        if ($status && in_array($status, ['to be confirmed', 'confirmed', 'to be scheduled', 'surrender on-going', 'completed', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('full_name', 'like', "%$search%")
                ;
            });
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
        $search = $request->get('search');

        $query = MissingPetReport::where('user_id', $userId);

        // Exclude archived reports
        $query->where('status', '!=', 'archived');

        // Status filter
        if ($status && in_array($status, ['pending', 'approved', 'rejected', 'found'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%$search%")
                    ->orWhere('pet_name', 'like', "%$search%")
                    ->orWhere('contact_no', 'like', "%$search%");
            });
        }

        // Apply sorting - newest first by default
        $direction = $request->get('direction', 'desc');
        $query->orderBy('created_at', $direction === 'asc' ? 'asc' : 'desc');

        $perPage = request()->get('per_page', 12);
        $reports = $query->paginate($perPage)->appends($request->query());

        return view('transactions.missing', [
            'missingReports' => $reports,
            'status' => $status,
        ]);
    }
    public function abused(Request $request)
    {
        $userId = Auth::id();
        $status = $request->get('status');
        $search = $request->get('search');

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

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('report_number', 'like', "%$search%")
                    ->orWhere('full_name', 'like', "%$search%")
                    ->orWhere('contact_no', 'like', "%$search%")
                ;
            });
        }

        $perPage = request()->get('per_page', 12);
        $reports = $query->latest()->paginate($perPage);

        return view('transactions.abused', [
            'abusedReports' => $reports,
            'status' => $status,
        ]);
    }
}
