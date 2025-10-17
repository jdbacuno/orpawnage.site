<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\FeaturedPet;
class FeaturedPetController extends Controller
{
    public function index()
    {
	$perPage = request()->get('per_page', 8); // Use 8 as default if not provided

        $featuredPets = FeaturedPet::with('pet')
            ->whereHas('pet', function ($query) {
                // Only include pets that are not archived
                $query->whereNull('archived_at');
            })
            ->whereDoesntHave('pet.adoptionApplication', function ($query) {
                // Exclude pets that have adoption applications in these statuses
                $query->whereIn('status', [
                    'picked up', 
                    'to be scheduled', 
                    'to be picked up', 
                    'to be confirmed', 
                    'confirmed', 
                    'adoption on-going', 
                    'archived'
                ]);
            })
            ->orderBy('adoption_probability', 'ASC') // Show lowest probability first
            ->paginate($perPage)->appends(request()->query());
        return view('featured', compact('featuredPets'));
    }
}
