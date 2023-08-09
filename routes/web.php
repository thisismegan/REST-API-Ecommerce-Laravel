<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\TiktokLoginController;
use App\Http\Controllers\User\ProfileController;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('create.login');
    Route::post('login', [LoginController::class, 'store'])->name('store.login');
    Route::get('register', [RegisterController::class, 'create'])->name('create.register');
    Route::post('register', [RegisterController::class, 'store'])->name('store.register');

    // login medsos
    Route::get('auth/redirect/{provider}', [SocialAccountController::class, 'redirectProvider'])->name('auth.redirect');
    Route::get('auth/callback/{provider}', [SocialAccountController::class, 'callbackProvider'])->name('auth.callback');
    Route::get('redirect/tiktok', [TiktokLoginController::class, 'redirect'])->name('redirect.tiktok');
    Route::get('callback/tiktok', [TiktokLoginController::class, 'callback'])->name('callback.tiktok');
});

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('profile', ProfileController::class);
});
