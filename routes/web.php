<?php

use App\Http\Controllers\LandlordViewController;
use App\Http\Controllers\TenantViewController;
use App\Http\Controllers\ContractorViewController;
use App\Http\Controllers\PropertyController;
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
    Route::get('/landlord/dashboard', [LandlordViewController::class, 'dashboard'])->name('landlord.dashboard');
});

Route::middleware('role:tenant')->group(function () {
    Route::get('/tenant/dashboard', [TenantViewController::class, 'dashboard'])->name('tenant.dashboard');
});

Route::middleware('role:contractor')->group(function () {
    Route::get('/contractor/dashboard', [ContractorViewController::class, 'dashboard'])->name('contractor.dashboard');
});


Route::middleware(['auth', 'role:landlord'])->group(function () {
    // House routes
    Route::get('/properties', [PropertyController::class, 'showHouses'])->name('landlord.properties.index');
    Route::get('/properties/create', [PropertyController::class, 'createHouse'])->name('landlord.properties.create');
    Route::post('/properties', [PropertyController::class, 'storeHouse'])->name('landlord.properties.store');
    Route::get('/properties/{house}', [PropertyController::class, 'showHouse'])->name('landlord.properties.show');
    Route::delete('/properties/{house}', [PropertyController::class, 'deleteHouse'])->name('landlord.properties.delete');

    // Room routes
    Route::get('/properties/{house}/rooms/create', [PropertyController::class, 'createRoom'])->name('landlord.properties.rooms.create');
    Route::post('/properties/{house}/rooms', [PropertyController::class, 'storeRoom'])->name('landlord.properties.rooms.store');
    Route::delete('/rooms/{room}', [PropertyController::class, 'deleteRoom'])->name('landlord.properties.rooms.delete');

    // Item routes
    Route::get('/rooms/{room}/items/create', [PropertyController::class, 'createItem'])->name('landlord.properties.items.create');
    Route::post('/rooms/{room}/items', [PropertyController::class, 'storeItem'])->name('landlord.properties.items.store');
    Route::delete('/items/{item}', [PropertyController::class, 'deleteItem'])->name('landlord.properties.items.delete');
    
    // Add this new route for fetching room items
    Route::get('/rooms/{room}/items', [PropertyController::class, 'getRoomItems'])->name('landlord.properties.rooms.items');
});

