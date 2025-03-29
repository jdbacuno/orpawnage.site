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
        $adoptionApplications = AdoptionApplication::with('pet')
            ->where('user_id', Auth::id()) // Only fetch the current user's applications
            ->paginate(5); // Paginate with 5 items per page

        return view('transactions', compact('adoptionApplications'));
    }


    public function destroy(AdoptionApplication $application)
    {
        $application->delete();

        return redirect()->back()->with('success', 'Adoption request deleted successfully.');
    }
}
