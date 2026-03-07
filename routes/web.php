<?php

use App\Http\Controllers\OwnerAuthController;
use App\Http\Controllers\OwnerLoginController;
use App\Http\Controllers\OwnerProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;


require __DIR__.'/owner.php';

require __DIR__.'/customer.php';

Route::get('/', function (): View {
    return view('welcome');
});

Route::get('/login', fn () => redirect()->route('owner.login'))->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('owner.login');
})->middleware('auth')->name('logout');


Route::post('/owner/signup', [OwnerAuthController::class, 'store'])
    ->name('owner.signup.store');

