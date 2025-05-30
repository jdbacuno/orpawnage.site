<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserBannedNotification;
use App\Notifications\UserUnbannedNotification;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('isAdmin', false);

        // Search filter
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status')) {
            switch ($request->status) {
                case 'banned':
                    $query->where('is_banned', true);
                    break;
                case 'active':
                    $query->where('is_banned', false);
                    break;
                case 'verified':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'unverified':
                    $query->whereNull('email_verified_at');
                    break;
            }
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $users = $query->paginate(15)->appends($request->query());

        return view('admin.users', compact('users'));
    }

    public function show(Request $request)
    {
        // Prevent banned users from staying on /banned after being unbanned
        if (Auth::check() && !Auth::user()->banned_at && $request->is('banned')) {
            return redirect('/');
        }

        return view('auth.banned-notice');
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'ban_reason' => 'required|string|max:500'
        ]);

        $user->update([
            'is_banned' => true,
            'ban_reason' => $request->ban_reason,
            'banned_at' => now()
        ]);

        $user->notify(new UserBannedNotification($user));

        return back()->with('success', 'User has been banned successfully.');
    }

    public function unban(User $user)
    {
        $user->update([
            'is_banned' => false,
            'ban_reason' => null,
            'banned_at' => null
        ]);

        $user->notify(new UserUnbannedNotification($user));

        return back()->with('success', 'User has been unbanned successfully.');
    }

    public function showDetails(User $user)
    {
        // Load user's related data
        $user->load([
            'adoptionApplications' => function ($query) {
                $query->latest()->limit(5);
            },
            'animalAbuseReports' => function ($query) {
                $query->latest()->limit(5);
            },
            'missingPetReports' => function ($query) {
                $query->latest()->limit(5);
            }
        ]);

        return view('admin.user-details-modal', compact('user'));
    }
}
