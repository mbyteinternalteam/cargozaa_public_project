<?php

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

// Route::prefix('customer')->name('customer.')->group(function (): void {

Route::middleware(['auth', 'customer'])->name('customer.')->group(function (): void {
    Route::get('dashboard', fn (): View => view('customer.dashboard'))->name('dashboard');
    Route::get('/profile', \App\Livewire\Customer\ProfilePage::class)->name('profile');

    Route::get('/search', \App\Livewire\Customer\explore\SearchPage::class)->name('search');
    Route::get('/containers/{container}', \App\Livewire\Customer\explore\ContainerShowPage::class)->name('containers.show')->scopeBindings();

    Route::get('/orders/review/{container}', \App\Livewire\Customer\orders\OrderReviewPage::class)->name('orders.review');
    Route::get('/orders/{order}/success', \App\Livewire\Customer\orders\PaymentSuccessPage::class)->name('orders.payment-success');
    Route::get('/orders/{order}/failed', \App\Livewire\Customer\orders\PaymentFailedPage::class)->name('orders.payment-failed');
});
// });
