<?php

use App\Livewire\OrderList;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Студии
    Route::get('/studios', \App\Livewire\Admin\Studio\StudioList::class)->name('admin.studios.index');
    Route::get('/studios/create', \App\Livewire\Admin\Studio\StudioForm::class)->name('admin.studios.create');
    Route::get('/studios/{studio}/edit', \App\Livewire\Admin\Studio\StudioForm::class)->name('admin.studios.edit');
});



require __DIR__.'/auth.php';
