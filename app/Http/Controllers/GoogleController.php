<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create new user with Google data
                $user = $this->createUserFromGoogle($googleUser);
            } else {
                // Update existing user with Google ID if missing
                $this->updateUserWithGoogle($user, $googleUser);
            }

            // Log the user in
            Auth::login($user, true);

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect('/register')->withErrors([
                'google_auth' => 'Google authentication failed. Please try again or register manually.'
            ]);
        }
    }

    /**
     * Create a new user from Google data
     */
    protected function createUserFromGoogle($googleUser)
    {
        return User::create([
            'username' => $this->generateUniqueUsername($googleUser),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'email_verified_at' => now(),
            'password' => bcrypt(Str::random(24)), // Random password for security
        ]);
    }

    /**
     * Update existing user with Google ID
     */
    protected function updateUserWithGoogle($user, $googleUser)
    {
        if (empty($user->google_id)) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        if (empty($user->email_verified_at)) {
            $user->update(['email_verified_at' => now()]);
        }
    }

    /**
     * Generate a unique username from Google name
     */
    protected function generateUniqueUsername($googleUser)
    {
        $baseUsername = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $googleUser->getName()));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
