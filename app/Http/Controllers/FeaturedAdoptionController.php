<?php

namespace App\Http\Controllers;

use App\Models\FeaturedAdoption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class FeaturedAdoptionController extends Controller
{
  public function index()
  {
    $initialLimit = 12;
    $featuredPets = FeaturedAdoption::orderBy('created_at', 'DESC')->take($initialLimit)->get()
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
    $featuredPets = FeaturedAdoption::orderBy('created_at', 'DESC')->get()
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
      'images' => 'required|array|max:10', // Limit to 5 images max
      'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480', // 20MB per image
    ], [
      'images.max' => 'You can upload a maximum of 5 images at once.',
      'images.*.max' => 'Each image must be smaller than 2MB.',
    ]);

    if ($request->hasFile('images')) {
      $nextOrder = (FeaturedAdoption::max('order') ?? 0) + 1;
      $uploadedCount = 0;
      $errors = [];

      foreach ($request->file('images') as $index => $image) {
        try {
          // Check if file is valid
          if (!$image->isValid()) {
            $errors[] = "File " . ($index + 1) . " is invalid.";
            continue;
          }

          $filename = Str::random(20) . '.jpg'; // Always save as JPG for consistency
          $storagePath = 'featured_adoptions/' . $filename;
          $fullPath = storage_path('app/public/' . $storagePath);

          // Create directory if it doesn't exist
          $directory = dirname($fullPath);
          if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
          }

          // Resize and optimize the image using Intervention Image v3
          $manager = new ImageManager(new Driver());
          $image_obj = $manager->read($image->getPathname());
          
          // Resize image while maintaining aspect ratio (max 1200x1200)
          $image_obj->scale(width: 1200, height: 1200);
          
          // Save as JPEG with quality
          $image_obj->toJpeg(85)->save($fullPath);

          // Create database record
          FeaturedAdoption::create([
            'image_path' => $storagePath,
            'order' => $nextOrder++,
          ]);

          $uploadedCount++;
        } catch (\Exception $e) {
          $errors[] = "Failed to process file " . ($index + 1) . ": " . $e->getMessage();
        }
      }

      if ($uploadedCount > 0) {
        $message = "{$uploadedCount} image(s) uploaded and resized successfully!";
        if (!empty($errors)) {
          $message .= " However, some files failed: " . implode(', ', $errors);
        }
        return back()->with('success', $message);
      } else {
        return back()->with('error', 'No images were uploaded. Errors: ' . implode(', ', $errors));
      }
    }

    return back()->with('error', 'No images were selected.');
  }

  /**
   * Alternative method with multiple sizes (thumbnail, medium, large)
   */
  public function storeWithMultipleSizes(Request $request)
  {
    $request->validate([
      'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:20480',
    ]);

    if ($request->hasFile('images')) {
      $nextOrder = (FeaturedAdoption::max('order') ?? 0) + 1;
      
      foreach ($request->file('images') as $image) {
        $filename = Str::random(20);
        
        // Create multiple sizes
        $sizes = [
          'thumbnail' => ['width' => 300, 'height' => 300],
          'medium' => ['width' => 800, 'height' => 800],
          'large' => ['width' => 1200, 'height' => 1200],
        ];
        
        $savedPaths = [];
        
        foreach ($sizes as $size => $dimensions) {
          $sizedFilename = $filename . '_' . $size . '.jpg';
          $storagePath = 'featured_adoptions/' . $sizedFilename;
          $fullPath = storage_path('app/public/' . $storagePath);
          
          // Create directory if it doesn't exist
          $directory = dirname($fullPath);
          if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
          }
          
          // Resize and save
          Image::make($image->getPathname())
            ->resize($dimensions['width'], $dimensions['height'], function ($constraint) {
              $constraint->aspectRatio();
              $constraint->upsize();
            })
            ->orientate()
            ->save($fullPath, 85);
          
          $savedPaths[$size] = $storagePath;
        }
        
        // Save to database (using the large size as main image)
        FeaturedAdoption::create([
          'image_path' => $savedPaths['large'],
          'thumbnail_path' => $savedPaths['thumbnail'], // If you have this column
          'medium_path' => $savedPaths['medium'], // If you have this column
          'order' => $nextOrder++,
        ]);
      }
    }

    return back()->with('success', 'Images uploaded and resized successfully!');
  }

  public function update(Request $request, FeaturedAdoption $featuredPet)
  {
    $request->validate([
      'created_at' => 'required|date',
    ]);

    $featuredPet->update([
      'created_at' => $request->created_at,
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Adoption date updated successfully!',
      'new_month' => $featuredPet->created_at->format('F Y'),
      'new_month_slug' => Str::slug($featuredPet->created_at->format('F Y')),
      'new_month_num' => $featuredPet->created_at->format('n'),
      'new_year' => $featuredPet->created_at->format('Y'),
    ]);
  }

  public function destroy(FeaturedAdoption $featuredPet)
  {
    Storage::disk('public')->delete($featuredPet->image_path);
    $featuredPet->delete();

    return back()->with('success', 'Image deleted successfully!');
  }

  public function loadMore(Request $request)
  {
    $page = $request->query('page', 1);
    $perPage = 12;
    $offset = ($page * $perPage); // This skips the already loaded items

    $query = FeaturedAdoption::orderBy('created_at', 'DESC');

    // Filter by year if provided
    $year = $request->query('year');
    if ($year && $year !== 'all') {
      $query->whereYear('created_at', $year);
    }

    // Filter by month if provided
    $month = $request->query('month');
    if ($month && $month !== 'all') {
      $query->whereMonth('created_at', $month);
    }

    $featuredPets = $query
      ->skip($offset)
      ->take($perPage)
      ->get()
      ->groupBy(function ($item) {
        return $item->created_at->format('F Y');
      });

    return view('partials.featured-adoptions-load-more', compact('featuredPets'));
  }

  // Removed the custom PHP GD resize function since we're using Intervention Image v3
}
