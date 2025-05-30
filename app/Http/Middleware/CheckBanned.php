<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->banned_at) {
            // Redirect to banned notice for all other routes
            return redirect()->route('banned.notice');
        }

        return $next($request);
    }
}
