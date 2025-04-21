<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Protected routes with role middleware
Route::middleware('role:landlord')->group(function () {
    Route::get('/landlord/dashboard', function () {
        // Only landlords can access this
    });
});

Route::middleware('role:tenant')->group(function () {
    Route::get('/tenant/dashboard', function () {
        // Only tenants can access this
    });
});

Route::middleware('role:contractor')->group(function () {
    Route::get('/contractor/dashboard', function () {
        // Only contractors can access this
    });
});

