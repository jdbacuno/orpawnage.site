<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function adoption()
    {
        $query = AdoptionApplication::with('pet')
            ->where('user_id', Auth::id());

        if (request()->has('status') && in_array(request('status'), ['to be picked up', 'to be scheduled', 'picked up', 'rejected'])) {
            $query->where('status', request('status'));
        }

        $adoptionApplications = $query->orderByRaw("
            CASE status
                WHEN 'to be picked up' THEN 0
                WHEN 'to be scheduled' THEN 1
                WHEN 'picked up' THEN 2
                ELSE 3
            END
        ")->paginate(10);


        return view('transactions', compact('adoptionApplications'));
    }

    public function destroy(AdoptionApplication $application)
    {
        $application->delete();

        return redirect()->back()->with('success', 'Adoption request deleted successfully.');
    }
}
