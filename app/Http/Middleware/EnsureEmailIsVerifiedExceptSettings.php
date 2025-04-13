<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerifiedExceptSettings
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->hasVerifiedEmail()) {
            if (
                !$request->is('settings*') &&
                !$request->routeIs('verification.*') &&
                !$request->is('logout') // ✅ allow logout
            ) {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
