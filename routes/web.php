<?php

use App\Http\Controllers\OwnerAuthController;
use App\Http\Controllers\OwnerLoginController;
use App\Http\Controllers\OwnerProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::get('/login', fn () => redirect()->route('owner.login'))->name('login');

Route::get('/owner/login', [OwnerLoginController::class, 'show'])
    ->name('owner.login');

Route::post('/owner/login', [OwnerLoginController::class, 'login'])
    ->name('owner.login.attempt');

Route::get('/logout', function () {
    Auth::logout();

    return redirect()->route('owner.login');
})->middleware('auth')->name('logout');

Route::get('/owner/signup', [OwnerAuthController::class, 'create'])
    ->name('owner.signup');

Route::post('/owner/signup', [OwnerAuthController::class, 'store'])
    ->name('owner.signup.store');

Route::get('/owner/profile', OwnerProfileController::class)
    ->middleware('auth')
    ->name('owner.profile');

Route::get('/owner/dashboard', function (): View {
    return view('owner.dashboard');
})->middleware('auth')->name('owner.dashboard');
