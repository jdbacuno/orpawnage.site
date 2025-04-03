<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FeaturedPet;

class FeaturedPetController extends Controller
{
    public function index()
    {
        $featuredPets = FeaturedPet::with('pet') // Ensure the pet relationship is loaded
            ->orderBy('adoption_probability') // Show lowest probability first
            ->paginate(8); // Paginate with 8 per page

        return view('featured', compact('featuredPets'));
    }
}
