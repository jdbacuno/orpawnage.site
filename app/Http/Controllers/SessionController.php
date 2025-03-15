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
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $attributes['email'] = strtolower($attributes['email']);

        $user = User::where('email', $attributes['email'])->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'No account found with this email.'
            ]);
        }

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'password' => 'Incorrect password.'
            ]);
        }

        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
