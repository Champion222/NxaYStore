<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ListingController as AdminListingController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'email.verified'])->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/market', [PageController::class, 'market'])->name('market');
    Route::get('/orders', [PageController::class, 'orders'])->name('orders');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/billing', [BillingController::class, 'show'])->name('billing');
    Route::post('/billing/khqr', [BillingController::class, 'generate'])->name('billing.khqr.generate');
    Route::post('/billing/khqr/verify', [BillingController::class, 'verify'])->name('billing.khqr.verify');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [AuthController::class, 'showVerify'])->name('verification.notice');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    Route::post('/verify-email/resend', [AuthController::class, 'resendVerification'])->name('verification.resend');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'email.verified', 'admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class)->only(['index', 'edit', 'update', 'destroy']);
        Route::resource('listings', AdminListingController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::resource('orders', AdminOrderController::class)->only(['index', 'edit', 'update', 'destroy']);
    });

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.perform');
});
