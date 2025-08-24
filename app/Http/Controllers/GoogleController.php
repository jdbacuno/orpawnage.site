<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'username' => strtolower(str_replace(' ', '', $googleUser->getName()) . '_' . substr($googleUser->getId(), 0, 4)),
                    'email' => $googleUser->getEmail(),
                    'contact_number' => '',
                    'password' => bcrypt(rand(100000, 999999)),
                    'email_verified_at' => now(),
                    'signed_up_with_google' => true,
                    'has_set_password' => false,
                ]);

                $user->notify(new \App\Notifications\WelcomeNotification());
            }

            Auth::login($user);
            
            // Check for pending adoption confirmation
            if (session('pending_confirmation')) {
                $applicationId = session('pending_confirmation');
                session()->forget('pending_confirmation');
                
                // Redirect to the direct confirmation route for logged-in users
                return redirect()->route('adoption.confirm.direct', ['id' => $applicationId]);
            }
            
            return redirect($user->isAdmin ? '/admin' : '/');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Google login failed: ' . $e->getMessage());
        }
    }
}
