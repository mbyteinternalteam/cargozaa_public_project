<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::get('/signup', fn (): View => view('customer.auth.signup'))->name('signup');
Route::get('/login', fn (): View => view('customer.auth.login'))->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('owner.login');
})->middleware('auth')->name('logout');

require __DIR__.'/owner.php';

require __DIR__.'/customer.php';
