<?php

use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AnimalAbuseReportController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeaturedAdoptionController;
use App\Http\Controllers\FeaturedPetController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\MissingPetReportController;
use App\Http\Controllers\OfficeStaffController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SurrenderApplicationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Livewire\PetListing;
use App\Models\AdoptionApplication;
use App\Models\OfficeStaff;
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

    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
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

// Bug Report Route (accessible to all users)
Route::post('/bug-report', [BugReportController::class, 'store'])->name('bug-report.store');



// Signed In User Routes
Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {
    Route::view('/', 'home')->name('Home');

    Route::get('/featured-pets', [FeaturedPetController::class, 'index'])->name('Featured Pets');

    // Route::get('/services/adopt-a-pet', [PetController::class, 'index'])->name('Available Pets');
    Route::get('/services/adopt-a-pet', function () {
        return view('adopt-a-pet');
    })->name('Available Pets');

    Route::get('/debug-component', function () {
        return app(PetListing::class)->render();
    });

    Route::get('/services/surrender-an-animal', [SurrenderApplicationController::class, 'create'])->name('Surrender a Pet');

    Route::post('/services/surrender', [SurrenderApplicationController::class, 'store'])->name('surrender.store');
    Route::get('/confirm-surrender/{id}', [SurrenderApplicationController::class, 'confirmApplication'])->name('surrender.confirm');
    Route::post('/transactions/schedule-surrender/{id}', [SurrenderApplicationController::class, 'scheduleSurrender'])->name('schedule.surrender');
    Route::post('/transactions/{id}/resend-surrender-email', [SurrenderApplicationController::class, 'resendEmail']);
    Route::delete('/transactions/surrender-status/{application}', [SurrenderApplicationController::class, 'destroy']);

    Route::get('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'create'])->name('Adopt a Pet');
    Route::post('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'store']);

    Route::get('/report/missing-pet', function () {
        return view('missing-form');
    })->name('Report a Missing Pet');

    Route::post('/report/missing-pet', [MissingPetReportController::class, 'store'])->name('report.missing.pet');

    Route::get('/report/abused-stray-animal', function () {
        return view('abused-stray-form');
    })->name('report.animal.abuse');

    Route::post('/report/abused-stray-animal', [AnimalAbuseReportController::class, 'store']);

    Route::get('/transactions', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');
    Route::prefix('transactions')->group(function () {
        Route::get('/adoption-status', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');
        Route::post('/schedule-pickup/{id}', [AdoptionApplicationController::class, 'schedulePickup'])->name('schedule.pickup');
        Route::get('/surrender-status', [TransactionController::class, 'surrender'])->name('Surrender Applications Status');
        Route::get('/missing-status', [TransactionController::class, 'missing'])->name('Missing Reports Status');
        Route::get('/abused-status', [TransactionController::class, 'abused'])->name('Abused/Stray Reports Status');

        Route::delete('/missing-status/{missingReport}', [MissingPetReportController::class, 'destroy']);
        Route::delete('/abused-status/{abusedReport}', [AnimalAbuseReportController::class, 'destroy']);
        Route::delete('/adoption-status/{application}', [AdoptionApplication::class, 'destroy']);
    });

    Route::get('/about', function () {
        $staff = OfficeStaff::all();
        return view('about', compact('staff'));
    })->name('About Us');
    Route::view('/donate', 'donate')->name('Donate');

    Route::get('/confirm-application/{id}', [AdoptionApplicationController::class, 'confirmApplication'])
        ->name('adoption.confirm');
    Route::post('/transactions/{id}/resend-email', [AdoptionApplicationController::class, 'resendEmail']);
    Route::get('/transactions/adoption-status', [TransactionController::class, 'adoption'])
        ->name('transactions.adoption-status');

    Route::get('/featured-adoptions', [FeaturedAdoptionController::class, 'index'])->name('Featured Adoptions');
    Route::get('/featured-adoptions/load-more', [FeaturedAdoptionController::class, 'loadMore'])->name('featured-adoptions.load-more');

    Route::patch('/settings/password/setup', [SettingsController::class, 'setupPassword'])
        ->name('settings.password.setup');
});

Route::get('/banned', [UserController::class, 'show'])->name('banned.notice')->middleware('verified');

// Profile Settings Route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('settings')->group(function () {
        Route::patch('/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
        Route::patch('/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        Route::patch('/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
        Route::delete('/', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
    });
});

// Admin Routes
Route::middleware(['isAdmin', 'verified', 'auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('Home');
    Route::get('/admin/adoption-stats', [DashboardController::class, 'getAdoptionStats'])->name('admin.adoption-stats');
    Route::get('/admin/monthly-trend-stats', [DashboardController::class, 'getMonthlyTrendStats'])->name('admin.monthly-trend-stats');

    Route::get('/admin/pet-profiles', [PetController::class, 'create'])->name('admin.pet-profiles');
    Route::post('/admin/pet-profiles', [PetController::class, 'store'])->name('admin.pet-profiles.store');

    Route::patch('/admin/pet-profiles/{pet}', [PetController::class, 'update']);
    Route::patch('/admin/pet-profiles/{pet}/archive', [PetController::class, 'archive'])
        ->name('pets.archive');

    Route::patch('/admin/adoption-applications/archive', [AdoptionApplicationController::class, 'archive'])
        ->name('admin.adoption-applications.archive');
    Route::patch('/admin/surrender-applications/archive', [SurrenderApplicationController::class, 'archive'])
        ->name('admin.surrender-applications.archive');
    Route::patch('/admin/missing-pets/archive', [MissingPetReportController::class, 'archive'])
        ->name('admin.missing-reports.archive');
    Route::patch('/admin/abused-reports/archive', [AnimalAbuseReportController::class, 'archive'])
        ->name('admin.abused-reports.archive');

    Route::get('/admin/archives', [ArchiveController::class, 'index'])->name('archives');
    Route::patch('/admin/archives/{type}/{id}/restore', [ArchiveController::class, 'restore'])->name('admin.archives.restore');
    Route::delete('/admin/archives/{type}/{id}', [ArchiveController::class, 'destroy'])->name('archives.destroy');

    Route::get('/admin/surrender-applications', [SurrenderApplicationController::class, 'index'])->name('Manage Surrender Applications');
    Route::post('/admin/surrender-applications/move-to-schedule', [SurrenderApplicationController::class, 'moveToSchedule'])->name('surrender-applications.move-to-schedule');
    Route::patch('/admin/surrender-applications/completed', [SurrenderApplicationController::class, 'markAsCompleted'])->name('surrender-applications.completed');
    Route::patch('/admin/surrender-applications/reject', [SurrenderApplicationController::class, 'reject'])->name('surrender-applications.reject');
    // Route::patch('/admin/surrender-applications/archive', [SurrenderApplicationController::class, 'archive'])->name('admin.surrender-applications.archive');

    Route::get('/admin/adoption-applications', [AdoptionApplicationController::class, 'index'])->name('admin.adoption-applications');
    Route::post('/admin/adoption-applications/move-to-schedule', [AdoptionApplicationController::class, 'moveToSchedule'])->name('adoption-applications.move-to-schedule');

    Route::patch('/admin/adoption-applications/pickedup', [AdoptionApplicationController::class, 'markAsPickedUp']);
    Route::patch('/admin/adoption-applications/reject', [AdoptionApplicationController::class, 'reject']);

    Route::get('/admin/abused-or-stray-pets', [AnimalAbuseReportController::class, 'index'])->name('Manage Abused or Stray Pet Reports');
    Route::prefix('admin/abused-or-stray-pets')->name('admin.abused-reports.')->group(function () {
        Route::patch('/acknowledge', [AnimalAbuseReportController::class, 'acknowledge'])->name('acknowledge');
        Route::patch('/reject', [AnimalAbuseReportController::class, 'reject'])->name('reject');
    });

    Route::get('/admin/missing-pets', [MissingPetReportController::class, 'index'])->name('Manage Missing Pet Reports');
    Route::prefix('admin/missing-pet-reports')->name('admin.missing-reports.')->group(function () {
        Route::patch('/acknowledge', [MissingPetReportController::class, 'acknowledge'])->name('acknowledge');
        Route::patch('/reject', [MissingPetReportController::class, 'reject'])->name('reject');
    });

    Route::prefix('admin/settings')->group(function () {
        Route::patch('/email', [SettingsController::class, 'adminUpdateEmail'])->name('admin.settings.email.update');
        Route::patch('/password', [SettingsController::class, 'adminUpdatePassword'])->name('admin.settings.password.update');
        Route::patch('/contact', [SettingsController::class, 'adminUpdateContact'])->name('admin.settings.contact.update');
    });

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/ban', [UserController::class, 'ban'])->name('admin.users.ban');
    Route::patch('/admin/users/{user}/unban', [UserController::class, 'unban'])->name('admin.users.unban');
    Route::get('/admin/users/{user}/details', [UserController::class, 'showDetails'])->name('admin.users.details');

    Route::get('/admin/team-members', [OfficeStaffController::class, 'index'])->name('team.management');
    Route::post('/admin/office-staff', [OfficeStaffController::class, 'store'])->name('office-staff.store');
    Route::patch('/admin/office-staff/{staff}', [OfficeStaffController::class, 'update']);
    Route::delete('/admin/office-staff/{staff}', [OfficeStaffController::class, 'destroy']);
    Route::patch('/admin/office-staff/{staff}/update-order', [OfficeStaffController::class, 'updateOrder'])
        ->name('office-staff.update-order');

    Route::get('/admin/featured-adoptions', [FeaturedAdoptionController::class, 'adminIndex'])->name('admin.featured.adoptions');
Route::post('/admin/featured-adoptions', [FeaturedAdoptionController::class, 'store'])->name('featured-adoptions.store');
Route::delete('/admin/featured-adoptions/{featuredPet}', [FeaturedAdoptionController::class, 'destroy'])->name('featured-adoptions.destroy');
Route::patch('/admin/featured-adoptions/{featuredPet}/update-order', [FeaturedAdoptionController::class, 'updateOrder'])->name('featured-adoptions.update-order');

// Bug Report Management
Route::get('/admin/bug-reports', [BugReportController::class, 'index'])->name('admin.bug-reports');
Route::patch('/admin/bug-reports/{bugReport}/status', [BugReportController::class, 'updateStatus'])->name('admin.bug-reports.update-status');
Route::delete('/admin/bug-reports/{bugReport}', [BugReportController::class, 'destroy'])->name('admin.bug-reports.destroy');
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
    return redirect()->away('mailto:orpawnagedevelopers@gmail.com');
});


// for all undefined routes
Route::fallback(function () {
    abort(404);
});
