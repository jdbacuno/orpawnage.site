<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $credentials['email'] = strtolower($credentials['email']);
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'No account found with this email'
            ]);
        }

        // Check if user registered via Google (has random password)
        if ($user->password === null || $user->password === '') {
            throw ValidationException::withMessages([
                'email' => 'This account was created via Google. Please sign in with Google.'
            ]);
        }

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'password' => 'Incorrect password'
            ]);
        }

        $request->session()->regenerate();

        if (!$user->hasVerifiedEmail() && !$user->isAdmin) {
            return redirect()->route('verification.notice');
        }

        return $user->isAdmin ? redirect('/admin') : redirect('/');
    }


    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
