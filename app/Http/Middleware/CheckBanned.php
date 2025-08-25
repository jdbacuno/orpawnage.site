<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check for permanent ban
            if ($user->banned_at) {
                // Allow access to logout route, banned notice, and password reset routes
                if (!$request->is('banned') && !$request->is('logout') && !$request->is('password.*')) {
                    return redirect()->route('banned.notice');
                }
            }
            
            // Check for temporary ban
            if ($user->is_temporarily_banned && $user->temporary_ban_expires_at && $user->temporary_ban_expires_at->isFuture()) {
                // Allow access to logout route, banned notice, and password reset routes
                if (!$request->is('banned') && !$request->is('logout') && !$request->is('password.*')) {
                    return redirect()->route('banned.notice');
                }
            }
        }

        return $next($request);
    }
}
