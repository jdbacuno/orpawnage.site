<?php

use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/services/adopt-a-pet', function () {
        return view('adopt-a-pet');
    });

    Route::get('/services/adoption-form', function () {
        return view('adoption-form');
    });

    Route::get('/services/surrender-an-animal', function () {
        return view('surrender');
    });

    Route::get('/report/missing-pet', function () {
        return view('missing-form');
    });

    Route::get('/report/abused-stray-animal', function () {
        return view('abused-stray-form');
    });

    Route::view('/about', 'about');
    Route::view('/donate', 'donate');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [SessionController::class, 'create'])->name('login');
    Route::post('/login', [SessionController::class, 'store']);
});

Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');
