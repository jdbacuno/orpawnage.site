<?php

namespace App\Http\Controllers;

use App\Models\FeaturedAdoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class FeaturedAdoptionController extends Controller
{
  public function index()
  {
    $initialLimit = 12;
    $featuredPets = FeaturedAdoption::orderBy('order')->take($initialLimit)->get()
      ->groupBy(function ($item) {
        return $item->created_at->format('F Y');
      });

    // Get all unique years from the data
    $years = FeaturedAdoption::selectRaw('YEAR(created_at) as year')
      ->distinct()
      ->orderBy('year', 'desc')
      ->pluck('year');

    // Get available months from data
    $availableMonths = FeaturedAdoption::selectRaw('MONTH(created_at) as month')
      ->distinct()
      ->orderBy('month')
      ->pluck('month');

    // Map numeric months to their names
    $monthNames = [
      1 => 'January',
      2 => 'February',
      3 => 'March',
      4 => 'April',
      5 => 'May',
      6 => 'June',
      7 => 'July',
      8 => 'August',
      9 => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December',
    ];

    $months = $availableMonths->map(function ($month) use ($monthNames) {
      return [
        'value' => $month,
        'name' => $monthNames[$month],
      ];
    });

    $totalImages = FeaturedAdoption::count();

    return view('featured-adoptions', compact('featuredPets', 'years', 'months', 'totalImages', 'initialLimit'));
  }

  // Admin panel
  public function adminIndex()
  {
    $featuredPets = FeaturedAdoption::orderBy('order')->get()
      ->groupBy(function ($item) {
        return $item->created_at->format('F Y');
      });

    // Get all unique years from the data
    $years = FeaturedAdoption::selectRaw('YEAR(created_at) as year')
      ->distinct()
      ->orderBy('year', 'desc')
      ->pluck('year');

    // Get available months from data
    $availableMonths = FeaturedAdoption::selectRaw('MONTH(created_at) as month')
      ->distinct()
      ->orderBy('month')
      ->pluck('month');

    // Map numeric months to their names
    $monthNames = [
      1 => 'January',
      2 => 'February',
      3 => 'March',
      4 => 'April',
      5 => 'May',
      6 => 'June',
      7 => 'July',
      8 => 'August',
      9 => 'September',
      10 => 'October',
      11 => 'November',
      12 => 'December',
    ];

    $months = $availableMonths->map(function ($month) use ($monthNames) {
      return [
        'value' => $month,
        'name' => $monthNames[$month],
      ];
    });

    return view('admin.featured-adoptions', compact('featuredPets', 'years', 'months'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
    ]);

    if ($request->hasFile('images')) {
      foreach ($request->file('images') as $image) {
        $filename = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('featured_adoptions', $filename, 'public');

        FeaturedAdoption::create([
          'image_path' => $path,
          'order' => FeaturedAdoption::max('order') + 1,
        ]);
      }
    }

    return back()->with('success', 'Images uploaded successfully!');
  }

  public function destroy(FeaturedAdoption $featuredPet)
  {
    Storage::disk('public')->delete($featuredPet->image_path);
    $featuredPet->delete();

    return back()->with('success', 'Image deleted successfully!');
  }

  public function loadMore(Request $request)
  {
    $page = $request->query('page', 1); // Start from page 1
    $perPage = 12;

    $featuredPets = FeaturedAdoption::orderBy('order')
      ->skip($page * $perPage) // Changed from (page-1)*perPage
      ->take($perPage)
      ->get()
      ->groupBy(function ($item) {
        return $item->created_at->format('F Y');
      });

    return view('partials.featured-adoptions-load-more', compact('featuredPets'));
  }
}
