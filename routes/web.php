<?php

use App\Http\Controllers\AdoptionApplicationController;
use App\Http\Controllers\AnimalAbuseReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeaturedPetController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Guest Routes (Login/Sign Up)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

// Email Verification Routes
// These routes handle the email verification process
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

// Signed In User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/', 'home')->name('Home');

    Route::get('/featured-pets', [FeaturedPetController::class, 'index'])->name('Featured Pets');

    Route::get('/services/adopt-a-pet', [PetController::class, 'index'])->name('Available Pets');

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
        Route::get('/surrender-status', [TransactionController::class, 'surrender'])->name('Surrender Applications Status');
        Route::get('/missing-status', [TransactionController::class, 'missing'])->name('Missing Reports Status');
        Route::get('/abused-status', [TransactionController::class, 'abused'])->name('Abused/Stray Reports Status');

        Route::delete('/abused-status/{abusedReport}', [AnimalAbuseReportController::class, 'destroy']);
    });

    Route::delete('/transactions/{application}', [TransactionController::class, 'destroy']);

    Route::view('/about', 'about')->name('About Us');
    Route::view('/donate', 'donate')->name('Donate');
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

    Route::patch('/admin/adoption-applications/approve', [AdoptionApplicationController::class, 'approve']);
    Route::patch('/admin/adoption-applications/pickedup', [AdoptionApplicationController::class, 'markAsPickedUp']);
    Route::patch('/admin/adoption-applications/reject', [AdoptionApplicationController::class, 'reject']);

    Route::get('/admin/abused-or-stray-pets', [AnimalAbuseReportController::class, 'index'])->name('Manage Abused or Stray Pet Reports');

    Route::prefix('admin/abused-or-stray-pets')->group(function () {
        Route::patch('/acknowledge', [AnimalAbuseReportController::class, 'acknowledge']);
        Route::patch('/reject', [AnimalAbuseReportController::class, 'reject']);
    });
});

// for all undefined routes
Route::fallback(function () {
    abort(404);
});

// Logout Route
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
