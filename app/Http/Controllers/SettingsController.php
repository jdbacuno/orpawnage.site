<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BugReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Notifications\AccountDeleted;
use App\Notifications\PasswordChanged;
use App\Notifications\ContactNumberChanged;
use App\Notifications\EmailChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'settings_email_current_password' => ['required', 'current_password'],
            'settings_email' => ['required', 'email', 'unique:users,email,' . Auth::id()]
        ]);

        $user = $request->user();
        $oldEmail = $user->email;
        $user->email = $request->settings_email;
        $user->email_verified_at = null;
        $user->save();

        // Send verification email for new address
        $user->sendEmailVerificationNotification();

        // Notify old email address about the change
        if (config('mail.old_email_notification')) {
            Notification::route('mail', $oldEmail)->notify(new EmailChanged($user));
        }

        return redirect()->back()
            ->with('settings-success', 'Email updated successfully! Please verify your new email address.')
            ->withFragment('settingsModal?tab=account-tab');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'settings_current_password' => ['required', 'current_password'],
            'settings_password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->settings_password)
        ]);

        // Send password change notification
        $user->notify(new PasswordChanged());

        return redirect()->back()
            ->with('settings-success', 'Password updated successfully!')
            ->withFragment('settingsModal?tab=password-tab');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'settings_contact_current_password' => ['required', 'current_password'],
            'settings_contact_number' => ['required', 'string', 'regex:/^09\d{9}$/', 'size:11']
        ]);

        $user = $request->user();
        $oldContact = $user->contact_number;
        $user->update([
            'contact_number' => $request->settings_contact_number
        ]);

        // Send contact number change notification
        $user->notify(new ContactNumberChanged($oldContact));

        return redirect()->back()
            ->with('settings-success', 'Contact number updated successfully!')
            ->withFragment('settingsModal?tab=account-tab');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'settings_delete_current_password' => ['required', 'current_password']
        ]);

        $user = $request->user();
        $userEmail = $user->email;
        $userId = $user->id;

        Log::info("Starting account deletion for user ID: {$userId} and email: {$userEmail}");

        try {
            /**
             * ==============================
             * COUNT RELATED RECORDS
             * ==============================
             */
            $adoptionCount  = \App\Models\AdoptionApplication::where('user_id', $userId)->count();
            $surrenderCount = \App\Models\SurrenderApplication::where('user_id', $userId)->count();
            $abuseCount     = \App\Models\AnimalAbuseReport::where('user_id', $userId)->count();
            $missingCount   = \App\Models\MissingPetReport::where('user_id', $userId)->count();
            $bugReportCount = \App\Models\BugReport::where('user_id', $userId)->count();

            Log::info("User {$userId} has: {$adoptionCount} adoptions, {$surrenderCount} surrenders, {$abuseCount} abuse reports, {$missingCount} missing reports, {$bugReportCount} bug reports");

            /**
             * ==============================
             * ARCHIVE PICKED-UP ADOPTION APPLICATIONS
             * ==============================
             */
            $pickedUpApps = \App\Models\AdoptionApplication::where('user_id', $userId)
                ->where('status', 'picked up')
                ->get();

            foreach ($pickedUpApps as $app) {
                DB::table('archived_adoption_applications')->insert([
                    'original_id'        => $app->id,
                    'pet_id'            => $app->pet_id,
                    'full_name'         => $app->full_name,
                    'email'             => $app->email,
                    'age'               => $app->age,
                    'birthdate'         => $app->birthdate,
                    'contact_number'    => $app->contact_number,
                    'address'           => $app->address,
                    'civil_status'      => $app->civil_status,
                    'citizenship'       => $app->citizenship,
                    'transaction_number' => $app->transaction_number,
                    'adopted_at'        => $app->updated_at,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            /**
             * ==============================
             * DELETE ADOPTION APPLICATIONS (WITH VALID ID FILES)
             * ==============================
             */
            Log::info("Deleting adoption applications and their valid IDs...");
            $adoptionApps = \App\Models\AdoptionApplication::where('user_id', $userId)->get();

            foreach ($adoptionApps as $adoption) {
                if (!empty($adoption->valid_id)) {
                    if (Storage::disk('public')->exists($adoption->valid_id)) {
                        Storage::disk('public')->delete($adoption->valid_id);
                        Log::info("Deleted adoption valid ID file: {$adoption->valid_id}");
                    } else {
                        Log::warning("Adoption valid ID file not found: {$adoption->valid_id}");
                    }
                }
            }

            \App\Models\AdoptionApplication::where('user_id', $userId)->delete();
            Log::info("Deleted {$adoptionApps->count()} adoption applications and associated valid ID files");

            /**
             * ==============================
             * DELETE SURRENDER APPLICATIONS
             * ==============================
             */
            Log::info("Deleting surrender applications...");
            $surrenderApps = \App\Models\SurrenderApplication::where('user_id', $userId)->get();

            foreach ($surrenderApps as $surrender) {
                // Delete valid ID
                if (!empty($surrender->valid_id_path) && Storage::disk('public')->exists($surrender->valid_id_path)) {
                    Storage::disk('public')->delete($surrender->valid_id_path);
                    Log::info("Deleted surrender valid ID file: {$surrender->valid_id_path}");
                }

                // Delete animal photos
                if (!empty($surrender->animal_photos)) {
                    $photos = json_decode($surrender->animal_photos, true);
                    if (is_array($photos)) {
                        foreach ($photos as $photo) {
                            if (Storage::disk('public')->exists($photo)) {
                                Storage::disk('public')->delete($photo);
                                Log::info("Deleted surrender animal photo: {$photo}");
                            }
                        }
                    }
                }
            }

            \App\Models\SurrenderApplication::where('user_id', $userId)->delete();
            Log::info("Deleted {$surrenderApps->count()} surrender applications");

            /**
             * ==============================
             * DELETE ANIMAL ABUSE REPORTS
             * ==============================
             */
            Log::info("Deleting animal abuse reports...");
            $abuseReports = \App\Models\AnimalAbuseReport::where('user_id', $userId)->get();

            foreach ($abuseReports as $report) {
                if (!empty($report->valid_id_path) && Storage::disk('public')->exists($report->valid_id_path)) {
                    Storage::disk('public')->delete($report->valid_id_path);
                    Log::info("Deleted abuse report valid ID file: {$report->valid_id_path}");
                }

                if (!empty($report->incident_photos)) {
                    $photos = json_decode($report->incident_photos, true);
                    if (is_array($photos)) {
                        foreach ($photos as $photo) {
                            if (Storage::disk('public')->exists($photo)) {
                                Storage::disk('public')->delete($photo);
                                Log::info("Deleted abuse incident photo: {$photo}");
                            }
                        }
                    }
                }
            }

            \App\Models\AnimalAbuseReport::where('user_id', $userId)->delete();
            Log::info("Deleted {$abuseReports->count()} animal abuse reports");

            /**
             * ==============================
             * DELETE MISSING PET REPORTS
             * ==============================
             */
            Log::info("Deleting missing pet reports...");
            $missingReports = \App\Models\MissingPetReport::where('user_id', $userId)->get();

            foreach ($missingReports as $report) {
                if (!empty($report->valid_id_path) && Storage::disk('public')->exists($report->valid_id_path)) {
                    Storage::disk('public')->delete($report->valid_id_path);
                    Log::info("Deleted missing report valid ID file: {$report->valid_id_path}");
                }

                if (!empty($report->pet_photos)) {
                    $photos = json_decode($report->pet_photos, true);
                    if (is_array($photos)) {
                        foreach ($photos as $photo) {
                            if (Storage::disk('public')->exists($photo)) {
                                Storage::disk('public')->delete($photo);
                                Log::info("Deleted missing pet photo: {$photo}");
                            }
                        }
                    }
                }

                if (!empty($report->location_photos)) {
                    $photos = json_decode($report->location_photos, true);
                    if (is_array($photos)) {
                        foreach ($photos as $photo) {
                            if (Storage::disk('public')->exists($photo)) {
                                Storage::disk('public')->delete($photo);
                                Log::info("Deleted missing location photo: {$photo}");
                            }
                        }
                    }
                }
            }

            \App\Models\MissingPetReport::where('user_id', $userId)->delete();
            Log::info("Deleted {$missingReports->count()} missing pet reports");

            /**
             * ==============================
             * DELETE BUG REPORTS
             * ==============================
             */
            Log::info("Deleting bug reports...");
            $bugReports = \App\Models\BugReport::where('user_id', $userId)->get();

            foreach ($bugReports as $bugReport) {
                if (!empty($bugReport->screenshot_path) && Storage::disk('public')->exists($bugReport->screenshot_path)) {
                    Storage::disk('public')->delete($bugReport->screenshot_path);
                    Log::info("Deleted bug report screenshot: {$bugReport->screenshot_path}");
                }
            }

            \App\Models\BugReport::where('user_id', $userId)->delete();
            Log::info("Deleted {$bugReports->count()} bug reports");

            /**
             * ==============================
             * DELETE USER ACCOUNT
             * ==============================
             */
            Log::info("Attempting to delete user account...");
            $deleted = \App\Models\User::find($userId)->forceDelete();
            if (!$deleted) {
                throw new \Exception("User forceDelete() returned false");
            }
            Log::info("User account deleted successfully");

            // Verify deletion
            if (\App\Models\User::find($userId)) {
                Log::error("User still exists after deletion attempt");
            }

            /**
             * ==============================
             * SEND ACCOUNT DELETION NOTIFICATION
             * ==============================
             */
            try {
                Notification::route('mail', $userEmail)->notify(new AccountDeleted());
            } catch (\Exception $e) {
                Log::warning('Failed to send account deletion notification: ' . $e->getMessage());
            }

            /**
             * ==============================
             * LOGOUT AND CLEANUP SESSION
             * ==============================
             */
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->session()->flush();

            if (Auth::check()) {
                Log::error("User still logged in after deletion!");
                $request->session()->forget('login_web_' . sha1(get_class($user)));
            }

            return redirect('/login')->with('success', 'Your account has been permanently deleted.');
        } catch (\Exception $e) {
            Log::error('Account deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete account: ' . $e->getMessage());
        }
    }

    public function setupPassword(Request $request)
    {
        $request->validate([
            'settings_password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->settings_password),
            'has_set_password' => true,
        ]);

        $user->notify(new PasswordChanged());

        return redirect()->back()
            ->with('settings-success', 'Password set successfully! You can now delete your account if needed.')
            ->withFragment('settingsModal?tab=password-tab');
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

        return back()->with('settings-success', 'Email updated successfully! Please verify your new email address.')
            ->withFragment('settingsModal?tab=account-tab');
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

        return back()->with('settings-success', 'Password updated successfully!')
            ->withFragment('settingsModal?tab=password-tab');
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

        return back()->with('settings-success', 'Contact number updated successfully!')
            ->withFragment('settingsModal?tab=password-tab');
    }
}
