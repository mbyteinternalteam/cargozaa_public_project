<?php

use App\Http\Controllers\OwnerAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::get('/owner/login', function (): View {
    return view('owner.auth.login');
})->name('owner.login');

Route::get('/owner/signup', [OwnerAuthController::class, 'create'])
    ->name('owner.signup');

Route::post('/owner/signup', [OwnerAuthController::class, 'store'])
    ->name('owner.signup.store');
