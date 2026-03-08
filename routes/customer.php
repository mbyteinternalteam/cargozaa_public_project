<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::prefix('customer')->name('customer.')->group(function (): void {

    Route::middleware(['auth', 'customer'])->group(function (): void {
        Route::get('dashboard', fn (): View => view('customer.dashboard'))->name('dashboard');
    });
});
