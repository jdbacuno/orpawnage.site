<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Notifications\AccountDeleted;
use App\Notifications\PasswordChanged;
use App\Notifications\ContactNumberChanged;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SettingsController extends Controller
{
    // FOR USER SETTINGS
    public function show()
    {
        return view('settings');
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::id()]
        ]);

        $user = $request->user();
        $oldEmail = $user->email;
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        // Send verification email for new address
        $user->sendEmailVerificationNotification();

        // Notify old email address about the change
        if (config('mail.old_email_notification')) {
            Notification::route('mail', $oldEmail)->notify(new EmailChanged($user)); // ✅ correct
        }

        return back()->with('success', 'Email updated successfully! Please verify your new email address.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
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

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Send password change notification
        $user->notify(new PasswordChanged());

        return back()->with('success', 'Password updated successfully!');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11']
        ]);

        $user = $request->user();
        $oldContact = $user->contact_number;
        $user->update([
            'contact_number' => $request->contact_number
        ]);

        // Send contact number change notification
        $user->notify(new ContactNumberChanged($oldContact));

        return back()->with('success', 'Contact number updated successfully!');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password_for_account_closure' => ['required', 'current_password']
        ]);

        $user = $request->user();

        // Send immediately (bypass queue)
        $user->notifyNow(new AccountDeleted());
        // Or: Notification::sendNow($user, new AccountDeleted());

        $user->delete();
        Auth::logout();

        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }

    // FOR ADMIN SETTINGS
    public function adminShow()
    {
        return view('admin.settings');
    }

    public function adminUpdateEmail(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'email' => ['required', 'email', 'unique:users,email,' . Auth::id()],
        ]);

        $user = $request->user();
        $oldEmail = $user->email;
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        $user->sendEmailVerificationNotification();

        if (config('mail.old_email_notification')) {
            Notification::route('mail', $oldEmail)->notify(new EmailChanged($user));
        }

        return back()->with('success', 'Email updated successfully! Please verify your new email address.');
    }

    public function adminUpdatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        $user->notify(new PasswordChanged());

        return back()->with('success', 'Password updated successfully!');
    }

    public function adminUpdateContact(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11'],
        ]);

        $user = $request->user();
        $oldContact = $user->contact_number;
        $user->update([
            'contact_number' => $request->contact_number
        ]);

        $user->notify(new ContactNumberChanged($oldContact));

        return back()->with('success', 'Contact number updated successfully!');
    }
}
