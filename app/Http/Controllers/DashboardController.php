<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('isAdmin', false)->count(); // Exclude admins
        $totalPets = Pet::count();
        $totalAdoptedPets = AdoptionApplication::where('status', 'picked up')->count();
        $totalIncompleteAdoptionApplications = AdoptionApplication::whereIn('status', ['to be picked up', 'to be scheduled'])->count();

        return view('admin.home', compact('totalUsers', 'totalPets', 'totalAdoptedPets', 'totalIncompleteAdoptionApplications'));
    }
}
