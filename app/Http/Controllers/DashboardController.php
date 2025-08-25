<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalUsers = User::where('isAdmin', false)->count(); // Exclude admins
        
        // Total available pets (not picked up or in-process for adoption)
        $totalAvailablePets = Pet::whereNull('archived_at')
            ->whereNotIn('id', function ($subQuery) {
                $subQuery->select('pet_id')
                    ->from('adoption_applications')
                    ->whereIn('status', ['picked up', 'to be scheduled', 'to be confirmed', 'confirmed', 'adoption on-going']);
            })->count();
        
        // Current month adoption rate
        $currentMonth = Carbon::now()->format('Y-m');
        $currentMonthAdoptions = AdoptionApplication::where('status', 'picked up')
            ->whereNotNull('pickup_date')
            ->whereYear('pickup_date', Carbon::now()->year)
            ->whereMonth('pickup_date', Carbon::now()->month)
            ->count();
        
        // Previous month adoption rate
        $previousMonth = Carbon::now()->subMonth()->format('Y-m');
        $previousMonthAdoptions = AdoptionApplication::where('status', 'picked up')
            ->whereNotNull('pickup_date')
            ->whereYear('pickup_date', Carbon::now()->subMonth()->year)
            ->whereMonth('pickup_date', Carbon::now()->subMonth()->month)
            ->count();
        
        // Total adopted pets (all time)
        $totalAdoptedPets = AdoptionApplication::where('status', 'picked up')->count();
        
        $totalIncompleteAdoptionApplications = AdoptionApplication::whereIn('status', ['to be confirmed', 'confirmed', 'to be picked up', 'adoption on-going', 'to be scheduled'])->count();

        // Chart data for current month adoption trend by species
        $currentMonthData = $this->getMonthlyAdoptionDataBySpecies(Carbon::now()->year, Carbon::now()->month);
        
        // Monthly trend data for the past 12 months (from 1 year ago to current month)
        $currentDate = Carbon::now();
        $oneYearAgo = $currentDate->copy()->subMonths(11); // 12 months including current month
        $monthlyTrendData = $this->getMonthlyTrendDataByDateRange(
            $oneYearAgo->format('Y-m'),
            $currentDate->format('Y-m')
        );
        
        // Additional statistics
        $totalPets = $totalAvailablePets; // Total Pets now shows currently available pets
        $totalArchivedPets = Pet::whereNotNull('archived_at')->count();
        $totalActivePets = Pet::whereNull('archived_at')->count();
        
        // Recent activity (last 7 days)
        $recentAdoptions = AdoptionApplication::where('status', 'picked up')
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->count();
        
        $recentApplications = AdoptionApplication::where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();

        return view('admin.home', compact(
            'totalUsers',
            'totalAvailablePets',
            'currentMonthAdoptions',
            'previousMonthAdoptions',
            'totalAdoptedPets',
            'totalIncompleteAdoptionApplications',
            'currentMonthData',
            'monthlyTrendData',
            'totalPets',
            'totalArchivedPets',
            'totalActivePets',
            'recentAdoptions',
            'recentApplications'
        ));
    }

    private function getMonthlyAdoptionDataBySpecies($year, $month)
    {
        $start = Carbon::create($year, $month, 1)->startOfDay();
        $end = Carbon::create($year, $month, 1)->endOfMonth()->endOfDay();

        $rows = AdoptionApplication::where('status', 'picked up')
            ->whereNotNull('pickup_date')
            ->whereBetween('pickup_date', [$start, $end])
            ->whereHas('pet', function ($q) {
                $q->whereIn('species', ['canine', 'feline']);
            })
            ->selectRaw("DATE(pickup_date) as d, (SELECT species FROM pets WHERE pets.id = adoption_applications.pet_id) as species, COUNT(*) as c")
            ->groupByRaw('DATE(pickup_date), species')
            ->orderByRaw('DATE(pickup_date)')
            ->get();

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $data = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $dateStr = $date->toDateString();
            $canine = $rows->firstWhere(fn($r) => $r->d === $dateStr && $r->species === 'canine')->c ?? 0;
            $feline = $rows->firstWhere(fn($r) => $r->d === $dateStr && $r->species === 'feline')->c ?? 0;
            $data[] = [
                'date' => $date->format('M d'),
                'canine' => (int) $canine,
                'feline' => (int) $feline,
            ];
        }

        return $data;
    }

    private function getMonthlyTrendDataBySpecies($months = 12, $endYear = null, $endMonth = null)
    {
        $data = [];
        
        // If no end date specified, use current month
        if ($endYear === null || $endMonth === null) {
            $endDate = Carbon::now();
        } else {
            $endDate = Carbon::create($endYear, $endMonth, 1);
        }
        
        // Calculate start date based on months back
        $startDate = $endDate->copy()->subMonths($months - 1);
        
        // Generate data for each month in the range
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $year = $currentDate->year;
            $month = $currentDate->month;
            
            // Get canine adoptions for this month
            $canineCount = AdoptionApplication::where('status', 'picked up')
                ->whereNotNull('pickup_date')
                ->whereYear('pickup_date', $year)
                ->whereMonth('pickup_date', $month)
                ->whereHas('pet', function($query) {
                    $query->where('species', 'canine');
                })
                ->count();
            
            // Get feline adoptions for this month
            $felineCount = AdoptionApplication::where('status', 'picked up')
                ->whereNotNull('pickup_date')
                ->whereYear('pickup_date', $year)
                ->whereMonth('pickup_date', $month)
                ->whereHas('pet', function($query) {
                    $query->where('species', 'feline');
                })
                ->count();
            
            $data[] = [
                'month' => $currentDate->format('M Y'),
                'canine' => $canineCount,
                'feline' => $felineCount
            ];
            
            $currentDate->addMonth();
        }
        
        return $data;
    }

    private function getMonthlyTrendDataByDateRange($startDate, $endDate)
    {
        // Parse the date strings (format: YYYY-MM)
        $start = Carbon::createFromFormat('Y-m', $startDate)->startOfMonth();
        $end = Carbon::createFromFormat('Y-m', $endDate)->endOfMonth();

        $rows = AdoptionApplication::where('status', 'picked up')
            ->whereNotNull('pickup_date')
            ->whereBetween('pickup_date', [$start, $end])
            ->whereHas('pet', function ($q) {
                $q->whereIn('species', ['canine', 'feline']);
            })
            ->selectRaw("DATE_FORMAT(pickup_date, '%Y-%m') as ym, (SELECT species FROM pets WHERE pets.id = adoption_applications.pet_id) as species, COUNT(*) as c")
            ->groupByRaw("DATE_FORMAT(pickup_date, '%Y-%m'), species")
            ->orderByRaw("DATE_FORMAT(pickup_date, '%Y-%m')")
            ->get();

        $data = [];
        $currentDate = $start->copy();
        while ($currentDate <= $end) {
            $ym = $currentDate->format('Y-m');
            $canine = $rows->firstWhere(fn($r) => $r->ym === $ym && $r->species === 'canine')->c ?? 0;
            $feline = $rows->firstWhere(fn($r) => $r->ym === $ym && $r->species === 'feline')->c ?? 0;
            $data[] = [
                'month' => $currentDate->format('M Y'),
                'canine' => (int) $canine,
                'feline' => (int) $feline,
            ];
            $currentDate->addMonth();
        }

        return $data;
    }

    private function getMonthlyAdoptionData($year, $month)
    {
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $data = [];
        
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);
            $count = AdoptionApplication::where('status', 'picked up')
                ->whereNotNull('pickup_date')
                ->whereDate('pickup_date', $date)
                ->count();
            
            $data[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }
        
        return $data;
    }

    public function getAdoptionStats(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);
        
        $data = $this->getMonthlyAdoptionDataBySpecies($year, $month);
        
        return response()->json($data);
    }

    public function getMonthlyTrendStats(Request $request)
    {
        $startDate = $request->get('startDate', '2024-01');
        $endDate = $request->get('endDate', '2024-12');
        $currentDate = Carbon::now()->format('Y-m');
        
        // Validate date range
        if ($startDate > $endDate) {
            return response()->json(['error' => 'Start date cannot be after end date'], 400);
        }
        
        if ($endDate > $currentDate) {
            return response()->json(['error' => 'End date cannot exceed current date'], 400);
        }
        
        // Validate range limit (maximum 2 years)
        $start = Carbon::createFromFormat('Y-m', $startDate);
        $end = Carbon::createFromFormat('Y-m', $endDate);
        $monthsDifference = $start->diffInMonths($end) + 1; // +1 to include both start and end months
        
        if ($monthsDifference > 24) {
            return response()->json(['error' => 'Date range cannot exceed 2 years (24 months)'], 400);
        }
        
        $data = $this->getMonthlyTrendDataByDateRange($startDate, $endDate);
        
        return response()->json($data);
    }
}
