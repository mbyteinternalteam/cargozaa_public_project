<?php

use App\Http\Controllers\OwnerAuthController;
use App\Http\Controllers\OwnerLoginController;
use App\Http\Controllers\OwnerProfileController;
use App\Livewire\Owner\Containers\CreatePage;
use App\Livewire\Owner\Containers\EditPage;
use App\Livewire\Owner\Containers\IndexPage as ContainerIndexPage;
use App\Livewire\Owner\Containers\ShowPage;
use App\Livewire\Owner\Orders\IndexPage as OrderIndexPage;
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
        })->middleware('owner.active')->name('dashboard');

        Route::get('containers', ContainerIndexPage::class)
            ->middleware('owner.active')->name('containers.index');

        Route::get('containers/create', CreatePage::class)
            ->middleware('owner.active')->name('containers.create');

        Route::get('containers/{container}/edit', EditPage::class)
            ->middleware('owner.active')->name('containers.edit');

        Route::get('containers/{container}', ShowPage::class)
            ->middleware('owner.active')->name('containers.show');

        Route::get('orders', OrderIndexPage::class)
            ->middleware('owner.active')->name('orders.index');
    });
});
