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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

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
            'email_current_password' => ['required', 'current_password'],
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
            Notification::route('mail', $oldEmail)->notify(new EmailChanged($user));
        }

        return redirect()->back()->with('success', 'Email updated successfully! Please verify your new email address.')->withFragment('settingsModal?tab=account-tab');
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

        return redirect()->back()->with('success', 'Password updated successfully!')->withFragment('settingsModal?tab=password-tab');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_current_password' => ['required', 'current_password'],
            'contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11']
        ]);

        $user = $request->user();
        $oldContact = $user->contact_number;
        $user->update([
            'contact_number' => $request->contact_number
        ]);

        // Send contact number change notification
        $user->notify(new ContactNumberChanged($oldContact));

        return redirect()->back()->with('success', 'Contact number updated successfully!')->withFragment('settingsModal?tab=account-tab');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'delete_current_password' => ['required', 'current_password']
        ]);

        $user = $request->user();

        // Archive picked-up applications
        $pickedUpApps = $user->adoptionApplications()->where('status', 'picked up')->get();

        foreach ($pickedUpApps as $app) {
            DB::table('archived_adoption_applications')->insert([
                'original_id' => $app->id,
                'pet_id' => $app->pet_id,
                'full_name' => $app->full_name,
                'email' => $app->email,
                'age' => $app->age,
                'birthdate' => $app->birthdate,
                'contact_number' => $app->contact_number,
                'address' => $app->address,
                'civil_status' => $app->civil_status,
                'citizenship' => $app->citizenship,
                'transaction_number' => $app->transaction_number,
                'adopted_at' => $app->updated_at,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Delete all applications (including picked up after archiving)
        $user->adoptionApplications()->delete();

        // Delete abuse reports & their images
        $user->animalAbuseReports()->each(function ($report) {
            if ($report->incident_photo) {
                Storage::disk('public')->delete($report->incident_photo);
            }
            $report->delete();
        });

        // Notify and hard delete user
        $user->notifyNow(new AccountDeleted());

        // Hard delete user
        $user->forceDelete();

        Auth::logout();

        return redirect('/login')->with('success', 'Your account has been permanently deleted.')->withFragment('settingsModal?tab=danger-tab');;
    }

    // FOR ADMIN SETTINGS
    public function adminShow()
    {
        return view('admin.settings');
    }

    public function adminUpdateEmail(Request $request)
    {
        $request->validate([
            'email_current_password' => ['required', 'current_password'],
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
            'contact_current_password' => ['required', 'current_password'],
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
