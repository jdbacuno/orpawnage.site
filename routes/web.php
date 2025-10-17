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
use Spatie\Sitemap\SitemapGenerator;
use Psr\Http\Message\UriInterface;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

Route::get('/generate-sitemap', function () {
    $sitemap = Sitemap::create();

    $urls = [
        config('app.url') . '/',
        config('app.url') . '/home',
        config('app.url') . '/services/adopt-a-pet',
        config('app.url') . '/services/surrender-an-animal',
        config('app.url') . '/report/missing-pet',
        config('app.url') . '/report/abused-stray-animal',
        config('app.url') . '/featured-pets',
        config('app.url') . '/featured-adoptions',
        config('app.url') . '/donate',
        config('app.url') . '/about',
        config('app.url') . '/privacy-policy',
        config('app.url') . '/terms-and-conditions',
	config('app.url') . '/missing-pets-browse',
    ];

    foreach ($urls as $url) {
        $sitemap->add(Url::create($url));
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap generated successfully with ' . count($urls) . ' URLs!';
});

// =============================================================================
// PUBLIC ROUTES - NO AUTHENTICATION REQUIRED
// =============================================================================

// Home Page
Route::view('/', 'home')->name('Home');

// Featured Pages
Route::get('/featured-pets', [FeaturedPetController::class, 'index'])->name('Featured Pets');
Route::get('/featured-adoptions', [FeaturedAdoptionController::class, 'index'])->name('Featured Adoptions');
Route::get('/featured-adoptions/load-more', [FeaturedAdoptionController::class, 'loadMore'])->name('featured-adoptions.load-more');

// Information Pages
Route::get('/about', function () {
    $staff = OfficeStaff::all();
    return view('about', compact('staff'));
})->name('About Us');
Route::view('/donate', 'donate')->name('Donate');
Route::view('/privacy-policy', 'privacy-policy')->name('Privacy Policy');
Route::view('/terms-and-conditions', 'terms-and-conditions')->name('Terms and Conditions');

// Forms - VIEWING (GET) is public, SUBMISSION (POST) requires auth
Route::get('/services/adopt-a-pet', function () {
    return view('adopt-a-pet');
})->name('Available Pets');

Route::get('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'create'])->name('Adopt a Pet');

Route::get('/services/surrender-an-animal', [SurrenderApplicationController::class, 'create'])->name('Surrender a Pet');

Route::get('/report/missing-pet', [MissingPetReportController::class, 'publicIndex'])->name('Report a Missing Pet');
Route::get('/missing-pets-browse', [MissingPetReportController::class, 'browsePage'])->name('Browse Missing Pets');

Route::get('/report/abused-stray-animal', function () {
    return view('abused-stray-form');
})->name('report.animal.abuse');

// Debug route (consider removing in production)
Route::get('/debug-component', function () {
    return app(PetListing::class)->render();
});

// Contact redirect
Route::get('/contact', function () {
    return redirect()->away('mailto:orpawnagedevelopers@gmail.com');
});

// Bug Report (accessible to all)
Route::post('/bug-report', [BugReportController::class, 'store'])->name('bug-report.store');

// =============================================================================
// GUEST ONLY ROUTES (Login/Register)
// =============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('Sign Up');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);

    Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

    // Password Reset Routes
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.update');
});

// =============================================================================
// EMAIL VERIFICATION ROUTES (Auth Required)
// =============================================================================

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function (Request $request) {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/');
        }

        $user->refresh();

        if ($user->hasVerifiedEmail()) {
            return redirect('/');
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

// Email verification callback (public link from email)
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

// =============================================================================
// AUTHENTICATED USER ROUTES - FORM SUBMISSIONS & PROTECTED PAGES
// =============================================================================

Route::middleware(['auth', 'verified', 'check.banned'])->group(function () {

    // Form Submissions (POST) - require authentication
    Route::post('/services/{pet:slug}/adoption-form', [AdoptionApplicationController::class, 'store']);
    Route::post('/services/surrender', [SurrenderApplicationController::class, 'store'])->name('surrender.store');
    Route::post('/report/missing-pet', [MissingPetReportController::class, 'store'])->name('report.missing.pet');
    Route::post('/report/abused-stray-animal', [AnimalAbuseReportController::class, 'store']);

    // Application Confirmations
    Route::get('/confirm-application/{application}', [AdoptionApplicationController::class, 'confirmApplication'])
        ->name('adoption.confirm');
    Route::get('/confirm-surrender/{id}', [SurrenderApplicationController::class, 'confirmApplication'])
        ->name('surrender.confirm');

    // Transaction Pages - require authentication
    Route::get('/transactions', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');
    Route::prefix('transactions')->group(function () {
        Route::get('/adoption-status', [TransactionController::class, 'adoption'])->name('Adoption Applications Status');
        Route::post('/schedule-pickup/{id}', [AdoptionApplicationController::class, 'schedulePickup'])->name('schedule.pickup');
        Route::post('/schedule-surrender/{id}', [SurrenderApplicationController::class, 'scheduleSurrender'])->name('schedule.surrender');

        Route::get('/surrender-status', [TransactionController::class, 'surrender'])->name('Surrender Applications Status');
        Route::get('/missing-status', [TransactionController::class, 'missing'])->name('Missing Reports Status');
        Route::post('/missing-status/mark-found', [MissingPetReportController::class, 'markAsFound'])->name('missing.mark-found');
        Route::post('/missing-status/repost', [MissingPetReportController::class, 'repost'])->name('missing.repost');
        Route::get('/abused-status', [TransactionController::class, 'abused'])->name('Abused/Stray Reports Status');

        // Delete actions
        Route::delete('/missing-status/{missingReport}', [MissingPetReportController::class, 'destroy']);
        Route::delete('/abused-status/{abusedReport}', [AnimalAbuseReportController::class, 'destroy']);
        Route::delete('/adoption-status/{application}', [AdoptionApplicationController::class, 'destroy'])
            ->name('adoption-applications.destroy');
        Route::delete('/surrender-status/{application}', [SurrenderApplicationController::class, 'destroy']);

        // Resend emails
        Route::post('/{id}/resend-email', [AdoptionApplicationController::class, 'resendEmail']);
        Route::post('/{id}/resend-surrender-email', [SurrenderApplicationController::class, 'resendEmail']);
    });

    // Profile Settings
    Route::prefix('settings')->group(function () {
        Route::patch('/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
        Route::patch('/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        Route::patch('/password/setup', [SettingsController::class, 'setupPassword'])->name('settings.password.setup');
        Route::patch('/contact', [SettingsController::class, 'updateContact'])->name('settings.contact.update');
        Route::delete('/', [SettingsController::class, 'deleteAccount'])->name('settings.delete');
    });
});

// Banned users page
Route::get('/banned', [UserController::class, 'show'])->name('banned.notice')->middleware('auth');

// Logout
Route::delete('/logout', [SessionController::class, 'destroy'])->name('logout')->middleware('auth');

// =============================================================================
// ADMIN ROUTES
// =============================================================================

Route::middleware(['isAdmin', 'verified', 'auth', 'check.banned'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('Home');
    Route::get('/admin/adoption-stats', [DashboardController::class, 'getAdoptionStats'])->name('admin.adoption-stats');
    Route::get('/admin/monthly-trend-stats', [DashboardController::class, 'getMonthlyTrendStats'])->name('admin.monthly-trend-stats');

    // Pet Profiles
    Route::get('/admin/pet-profiles', [PetController::class, 'create'])->name('admin.pet-profiles');
    Route::post('/admin/pet-profiles', [PetController::class, 'store'])->name('admin.pet-profiles.store');
    Route::patch('/admin/pet-profiles/{pet}', [PetController::class, 'update']);
    Route::patch('/admin/pet-profiles/{pet}/archive', [PetController::class, 'archive'])->name('pets.archive');

    // Archives
    Route::get('/admin/archives', [ArchiveController::class, 'index'])->name('archives');
    Route::patch('/admin/archives/{type}/{id}/restore', [ArchiveController::class, 'restore'])->name('admin.archives.restore');
    Route::delete('/admin/archives/{type}/{id}', [ArchiveController::class, 'destroy'])->name('archives.destroy');

    Route::patch('/admin/adoption-applications/archive', [AdoptionApplicationController::class, 'archive'])
        ->name('admin.adoption-applications.archive');
    Route::patch('/admin/surrender-applications/archive', [SurrenderApplicationController::class, 'archive'])
        ->name('admin.surrender-applications.archive');
    Route::patch('/admin/missing-pets/archive', [MissingPetReportController::class, 'archive'])
        ->name('admin.missing-reports.archive');
    Route::patch('/admin/abused-reports/archive', [AnimalAbuseReportController::class, 'archive'])
        ->name('admin.abused-reports.archive');

    // Surrender Applications
    Route::get('/admin/surrender-applications', [SurrenderApplicationController::class, 'index'])->name('Manage Surrender Applications');
    Route::post('/admin/surrender-applications/move-to-schedule', [SurrenderApplicationController::class, 'moveToSchedule'])->name('surrender-applications.move-to-schedule');
    Route::patch('/admin/surrender-applications/completed', [SurrenderApplicationController::class, 'markAsCompleted'])->name('surrender-applications.completed');
    Route::patch('/admin/surrender-applications/reject', [SurrenderApplicationController::class, 'reject'])->name('surrender-applications.reject');

    // Adoption Applications
    Route::get('/admin/adoption-applications', [AdoptionApplicationController::class, 'index'])->name('admin.adoption-applications');
    Route::post('/admin/adoption-applications/move-to-schedule', [AdoptionApplicationController::class, 'moveToSchedule'])->name('adoption-applications.move-to-schedule');
    Route::patch('/admin/adoption-applications/pickedup', [AdoptionApplicationController::class, 'markAsPickedUp']);
    Route::patch('/admin/adoption-applications/reject', [AdoptionApplicationController::class, 'reject']);

    // Abuse Reports
    Route::get('/admin/abused-or-stray-pets', [AnimalAbuseReportController::class, 'index'])->name('Manage Abused or Stray Pet Reports');
    Route::prefix('admin/abused-or-stray-pets')->name('admin.abused-reports.')->group(function () {
        Route::patch('/acknowledge', [AnimalAbuseReportController::class, 'acknowledge'])->name('acknowledge');
        Route::patch('/reject', [AnimalAbuseReportController::class, 'reject'])->name('reject');
    });

    // Missing Pet Reports
    Route::get('/admin/missing-pets', [MissingPetReportController::class, 'index'])->name('Manage Missing Pet Reports');
    Route::prefix('admin/missing-pet-reports')->name('admin.missing-reports.')->group(function () {
        Route::patch('/approve', [MissingPetReportController::class, 'approve'])->name('approve');
        Route::patch('/reject', [MissingPetReportController::class, 'reject'])->name('reject');
        Route::patch('/archive', [MissingPetReportController::class, 'archive'])->name('archive');
    });

    // Admin Settings
    Route::prefix('admin/settings')->group(function () {
        Route::patch('/email', [SettingsController::class, 'adminUpdateEmail'])->name('admin.settings.email.update');
        Route::patch('/password', [SettingsController::class, 'adminUpdatePassword'])->name('admin.settings.password.update');
        Route::patch('/contact', [SettingsController::class, 'adminUpdateContact'])->name('admin.settings.contact.update');
    });

    // User Management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::patch('/admin/users/{user}/ban', [UserController::class, 'ban'])->name('admin.users.ban');
    Route::patch('/admin/users/{user}/temporary-ban', [UserController::class, 'temporaryBan'])->name('admin.users.temporary-ban');
    Route::patch('/admin/users/{user}/unban', [UserController::class, 'unban'])->name('admin.users.unban');
    Route::get('/admin/users/{user}/details', [UserController::class, 'showDetails'])->name('admin.users.details');
    Route::post('/admin/users/{user}/password-reset', [UserController::class, 'sendPasswordReset'])->name('admin.users.password-reset');

    // Team Members
    Route::get('/admin/team-members', [OfficeStaffController::class, 'index'])->name('team.management');
    Route::post('/admin/office-staff', [OfficeStaffController::class, 'store'])->name('office-staff.store');
    Route::patch('/admin/office-staff/{staff}', [OfficeStaffController::class, 'update']);
    Route::delete('/admin/office-staff/{staff}', [OfficeStaffController::class, 'destroy']);
    Route::patch('/admin/office-staff/{staff}/update-order', [OfficeStaffController::class, 'updateOrder'])
        ->name('office-staff.update-order');

    // Featured Adoptions
    Route::prefix('admin/featured-adoptions')->group(function () {
        Route::get('/', [FeaturedAdoptionController::class, 'adminIndex'])->name('admin.featured.adoptions');
        Route::post('/', [FeaturedAdoptionController::class, 'store'])->name('featured-adoptions.store');
        Route::put('/{featuredPet}', [FeaturedAdoptionController::class, 'update'])->name('featured-adoptions.update');
        Route::delete('/{featuredPet}', [FeaturedAdoptionController::class, 'destroy'])->name('featured-adoptions.destroy');
        Route::patch('/{featuredPet}/update-order', [FeaturedAdoptionController::class, 'updateOrder'])->name('featured-adoptions.update-order');
    });

    // Bug Report Management
    Route::get('/admin/bug-reports', [BugReportController::class, 'index'])->name('admin.bug-reports');
    Route::patch('/admin/bug-reports/{bugReport}/status', [BugReportController::class, 'updateStatus'])->name('admin.bug-reports.update-status');
    Route::delete('/admin/bug-reports/{bugReport}', [BugReportController::class, 'destroy'])->name('admin.bug-reports.destroy');
});

// =============================================================================
// 404 FALLBACK
// =============================================================================

Route::fallback(function () {
    abort(404);
});
