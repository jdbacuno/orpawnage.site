<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'username' => ['required', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'], // check 'users' table, and in the 'email' field
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
        ]);

        $userAttributes['username'] = strtolower($userAttributes['username']);
        $userAttributes['email'] = strtolower($userAttributes['email']);

        User::create($userAttributes);

        return redirect('/register')->with('success', 'Successfully registered! You may now log in.');
    }
}
