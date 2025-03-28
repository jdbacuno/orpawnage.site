<?php

use App\Http\Controllers\PetController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Models\Pet;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('Home');

    Route::get('/services/adopt-a-pet', [PetController::class, 'index'])->name('Available Pets');

    Route::get('/services/surrender-an-animal', function () {
        return view('surrender');
    })->name('Surrender a Pet');

    Route::get('/services/{pet:slug}/adoption-form', function (Pet $pet) {
        return view('adoption-form', compact('pet'));
    })->name('Adopt a Pet');

    Route::get('/report/missing-pet', function () {
        return view('missing-form');
    })->name('Report a Missing Pet');

    Route::get('/report/abused-stray-animal', function () {
        return view('abused-stray-form');
    })->name('Report an Abuse / Stray Animal');

    Route::view('/about', 'about')->name('About Us');
    Route::view('/donate', 'donate')->name('Donate');

    Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});


Route::middleware(['isAdmin', 'auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.home');
    })->name('Home');

    Route::get('/admin/pet-profiles', [PetController::class, 'create'])->name('Manage Pet Profiles');
    Route::post('/admin/pet-profiles', [PetController::class, 'store'])->name('Manage Pet Profiles');

    Route::patch('/admin/pet-profiles/{pet}', [PetController::class, 'update']);

    Route::delete('/admin/pet-profiles/{pet}', [PetController::class, 'destroy']);
});

// for all undefined routes
Route::fallback(function () {
    abort(404);
});
