<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * Redirect to Google for authentication.
     *
     * This includes 'prompt=select_account' to always show the account chooser,
     * preventing automatic sign-in with the last used Google account on mobile.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account']) // ✅ Force account picker
            ->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     */
    public function handleGoogleCallback()
    {
        try {
            // Fetch the authenticated Google user details
            $googleUser = Socialite::driver('google')->user();

            // Find an existing user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            // If user doesn't exist, create a new one
            if (!$user) {
                $user = User::create([
                    'username' => strtolower(
                        str_replace(' ', '', $googleUser->getName()) . '_' . substr($googleUser->getId(), 0, 4)
                    ),
                    'email' => $googleUser->getEmail(),
                    'contact_number' => '',
                    'password' => bcrypt(rand(100000, 999999)), // Generate a random password
                    'email_verified_at' => now(),
                    'signed_up_with_google' => true,
                    'has_set_password' => false,
                ]);

                // Send a welcome notification to the new user
                $user->notify(new WelcomeNotification());
            }

            // Log the user into Laravel
            Auth::login($user);

            // Handle pending adoption confirmation redirect, if applicable
            if (session('pending_confirmation')) {
                $applicationId = session('pending_confirmation');
                session()->forget('pending_confirmation');

                return redirect()->route('adoption.confirm.direct', ['id' => $applicationId]);
            }

            // Redirect based on user role
            return redirect($user->isAdmin ? '/admin' : '/');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Google Login Error: ' . $e->getMessage());

            return redirect('/login')->with(
                'error',
                'Google login failed. Please try again later.'
            );
        }
    }

    /**
     * Logout user and clear session properly.
     */
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
