<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', function (): View {
    return view('welcome');
});

Route::get('/owner/login', function (): View {
    return view('owner.auth.login');
})->name('owner.login');
