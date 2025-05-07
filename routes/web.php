<?php

use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AnimalAbuseReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeaturedPetController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use App\Livewire\PetListing;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

// Guest Routes (Login/Sign Up)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('Sign Up');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function (Request $request) {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/'); // or wherever you want to send verified users
        }

        // Refresh to make sure email verification is reflected
        $user->refresh();

        // Check again after refresh
        if ($user->hasVerifiedEmail()) {
            return redirect('/'); // email just got verified, redirect them
        }

        return view('auth.verify-email');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->back()->with('status', 'already-verified');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});


// allow users to click from their email without being logged in
Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect('/login')->with('verified', true);
})->middleware(['signed'])->name('verification.verify');

// Signed In User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/', 'home')->name('Home');

    Route::get('/featured-pets', [FeaturedPetController::class, 'index'])->name('Featured Pets');

    // Route::get('/services/adopt-a-pet', [PetController::class, 'index'])->name('Available Pets');
    Route::get('/services/adopt-a-pet', function () {
        return view('adopt-a-pet');
    })->name('Available Pets');

    Route::get('/debug-component', function () {
        return app(PetListing::class)->render();
    });

    Route::get('/services/surrender-an-animal', function () {
        return view('surrender');
    })->name('Surrender a Pet');

    Route::get('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'create'])->name('Adopt a Pet');
    Route::post('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'store']);

    Route::get('/report/missing-pet', function () {
        return view('missing-form');
    })->name('Report a Missing Pet');

    Route::get('/report/abused-stray-animal', function () {
        return view('abused-stray-form');
    })->name('Report an Abuse / Stray Animal');

    Route::post('/report/abused-stray-animal', [AnimalAbuseReportController::class, 'store']);

    Route::get('/transactions', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');

    Route::prefix('transactions')->group(function () {
        Route::get('/adoption-status', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');
        Route::post('/schedule-pickup/{id}', [TransactionController::class, 'schedulePickup'])->name('schedule.pickup');
        Route::get('/surrender-status', [TransactionController::class, 'surrender'])->name('Surrender Applications Status');
        Route::get('/missing-status', [TransactionController::class, 'missing'])->name('Missing Reports Status');
        Route::get('/abused-status', [TransactionController::class, 'abused'])->name('Abused/Stray Reports Status');

        Route::delete('/abused-status/{abusedReport}', [AnimalAbuseReportController::class, 'destroy']);
    });

    Route::delete('/transactions/{application}', [TransactionController::class, 'destroy']);

    Route::view('/about', 'about')->name('About Us');
    Route::view('/donate', 'donate')->name('Donate');

    Route::get('/confirm-application/{id}', [AdoptionApplicationController::class, 'confirmApplication'])
        ->name('adoption.confirm');
    Route::post('/transactions/{id}/resend-email', [TransactionController::class, 'resendEmail']);
    Route::get('/transactions/adoption-status', [TransactionController::class, 'adoption'])
        ->name('transactions.adoption-status');
});

// Profile Settings Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'show'])->name('settings');
        Route::patch('/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
        Route::patch('/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        Route::patch('/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
        Route::delete('/', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
    });
});

// Admin Routes
Route::middleware(['isAdmin', 'verified', 'auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('Home');

    Route::get('/admin/pet-profiles', [PetController::class, 'create'])->name('Manage Pet Profiles');
    Route::post('/admin/pet-profiles', [PetController::class, 'store'])->name('Manage Pet Profiles');

    Route::patch('/admin/pet-profiles/{pet}', [PetController::class, 'update']);
    Route::delete('/admin/pet-profiles/{pet}', [PetController::class, 'destroy']);

    Route::get('/admin/adoption-applications', [AdoptionApplicationController::class, 'index'])->name('Manage Pet Adoption Applications');

    Route::post('/admin/adoption-applications/move-to-schedule', [AdoptionApplicationController::class, 'moveToSchedule'])->name('adoption-applications.move-to-schedule');

    Route::patch('/admin/adoption-applications/pickedup', [AdoptionApplicationController::class, 'markAsPickedUp']);
    Route::patch('/admin/adoption-applications/reject', [AdoptionApplicationController::class, 'reject']);

    Route::get('/admin/abused-or-stray-pets', [AnimalAbuseReportController::class, 'index'])->name('Manage Abused or Stray Pet Reports');

    Route::prefix('admin/abused-or-stray-pets')->group(function () {
        Route::patch('/acknowledge', [AnimalAbuseReportController::class, 'acknowledge']);
        Route::patch('/reject', [AnimalAbuseReportController::class, 'reject']);
    });

    Route::prefix('admin/settings')->group(function () {
        Route::get('/', [SettingsController::class, 'adminShow'])->name('Admin Profile Settings');
        Route::patch('/email', [SettingsController::class, 'adminUpdateEmail'])->name('admin.settings.email.update');
        Route::patch('/password', [SettingsController::class, 'adminUpdatePassword'])->name('admin.settings.password.update');
        Route::patch('/contact', [SettingsController::class, 'adminUpdateContact'])->name('admin.settings.contact.update');
        Route::delete('/', [SettingsController::class, 'adminDeleteAccount'])->name('admin.settings.delete');
    });
});

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.update');
});

// Logout Route
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('/contact', function () {
    return redirect()->away('mailto:orpawnageteam@gmail.com');
});


// for all undefined routes
Route::fallback(function () {
    abort(404);
});
