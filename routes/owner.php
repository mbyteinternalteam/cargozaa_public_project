<?php

use App\Http\Controllers\OwnerAuthController;
use App\Http\Controllers\OwnerLoginController;
use App\Http\Controllers\OwnerProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;


Route::prefix('owner')->name('owner.')->group(function (): void {
    Route::get('login', [OwnerLoginController::class, 'show'])
        ->name('login');

    Route::post('login', [OwnerLoginController::class, 'login'])
        ->name('login.attempt');

    Route::get('signup', [OwnerAuthController::class, 'create'])
        ->name('signup');

    Route::post('signup', [OwnerAuthController::class, 'store'])
        ->name('signup.store');

    Route::middleware('auth')->group(function (): void {
        Route::get('profile', OwnerProfileController::class)
            ->name('profile');

        Route::get('dashboard', function (): View {
            return view('owner.dashboard');
        })->name('dashboard');
    });
});

