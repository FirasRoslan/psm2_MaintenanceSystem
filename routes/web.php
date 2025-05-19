<?php

use App\Http\Controllers\LandlordViewController;
use App\Http\Controllers\TenantViewController;
use App\Http\Controllers\ContractorViewController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;

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
    
    // Maintenance request routes
    Route::get('/landlord/requests', [LandlordViewController::class, 'maintenanceRequests'])->name('landlord.requests.index');
    Route::put('/landlord/requests/{report}/status', [LandlordViewController::class, 'updateRequestStatus'])->name('landlord.requests.update-status');
    Route::get('/landlord/requests/{report}/assign', [LandlordViewController::class, 'showAssignTaskForm'])->name('landlord.requests.assign-task');
    Route::post('/landlord/requests/{report}/assign', [LandlordViewController::class, 'assignTask'])->name('landlord.requests.store-task');
    
    // Add these to your landlord routes
    Route::middleware('role:landlord')->group(function () {
        // Existing routes...
        
        // Contractor management routes
        Route::get('/landlord/contractors', [LandlordViewController::class, 'contractorRequests'])->name('landlord.contractors.index');
        Route::post('/landlord/contractors/{contractor}/approve', [LandlordViewController::class, 'approveContractor'])->name('landlord.contractors.approve');
        Route::post('/landlord/contractors/{contractor}/reject', [LandlordViewController::class, 'rejectContractor'])->name('landlord.contractors.reject');
    });
});

Route::middleware('role:tenant')->group(function () {
    Route::get('/tenant/dashboard', [TenantViewController::class, 'dashboard'])->name('tenant.dashboard');
    
    // Add this route for reports
    Route::get('/tenant/reports', [TenantViewController::class, 'reports'])->name('tenant.reports.index');
});

// Update the contractor routes
// Add this to your contractor routes
Route::middleware('role:contractor')->group(function () {
    Route::get('/contractor/dashboard', [ContractorViewController::class, 'dashboard'])->name('contractor.dashboard');
    Route::get('/contractor/find-landlords', [ContractorViewController::class, 'findLandlords'])->name('contractor.find-landlords');
    Route::get('/contractor/landlords/{landlord}/properties', [ContractorViewController::class, 'showLandlordProperties'])->name('contractor.landlord-properties');
    Route::post('/contractor/request-approval', [ContractorViewController::class, 'requestApproval'])->name('contractor.request-approval');
    Route::get('/contractor/approved-landlords', [ContractorViewController::class, 'viewApprovedLandlords'])->name('contractor.approved-landlords');
    Route::get('/contractor/tasks', [ContractorViewController::class, 'viewTasks'])->name('contractor.tasks');
    
    // Task status update route
    Route::put('/contractor/tasks/{task}/status', [ContractorViewController::class, 'updateTaskStatus'])->name('contractor.tasks.update-status');
});


// Add these routes if they're not already present
// Landlord routes
Route::middleware(['auth', 'role:landlord'])->prefix('landlord')->name('landlord.')->group(function () {
    // Properties
    Route::get('/properties', [PropertyController::class, 'showHouses'])->name('properties.index');
    Route::get('/properties/create', [PropertyController::class, 'createHouse'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'storeHouse'])->name('properties.store');
    Route::get('/properties/{house}', [PropertyController::class, 'showHouse'])->name('properties.show');
    Route::delete('/properties/{house}', [PropertyController::class, 'deleteHouse'])->name('properties.delete');

    // Rooms
    Route::get('/properties/{house}/rooms/create', [PropertyController::class, 'createRoom'])->name('properties.rooms.create');
    Route::post('/properties/{house}/rooms', [PropertyController::class, 'storeRoom'])->name('properties.rooms.store');
    Route::delete('/properties/rooms/{room}', [PropertyController::class, 'deleteRoom'])->name('properties.rooms.delete');

    // Items
    Route::get('/properties/rooms/{room}/items/create', [PropertyController::class, 'createItem'])->name('properties.rooms.items.create');
    Route::post('/properties/rooms/{room}/items', [PropertyController::class, 'storeItem'])->name('properties.rooms.items.store');
    Route::delete('/properties/items/{item}', [PropertyController::class, 'deleteItem'])->name('properties.items.delete');
    Route::get('/properties/rooms/{room}/items', [PropertyController::class, 'getRoomItems'])->name('properties.rooms.items.get');
    
    // Tenants
    Route::get('/tenants', [PropertyController::class, 'showTenants'])->name('tenants.index');
    Route::get('/tenants/create', [PropertyController::class, 'createTenant'])->name('tenants.create');
    Route::post('/tenants', [PropertyController::class, 'storeTenant'])->name('tenants.store');
    Route::get('/tenants/{tenant:userID}', [PropertyController::class, 'showTenant'])->name('tenants.show');
    Route::get('/tenants/{tenant:userID}/edit', [PropertyController::class, 'editTenant'])->name('tenants.edit');
    Route::put('/tenants/{tenant:userID}', [PropertyController::class, 'updateTenant'])->name('tenants.update');
    Route::delete('/tenants/{tenant:userID}', [PropertyController::class, 'deleteTenant'])->name('tenants.delete');
});

// Tenant routes
// Inside the tenant routes group
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/dashboard', [TenantViewController::class, 'dashboard'])->name('dashboard');
    Route::get('/find-houses', [TenantViewController::class, 'findHouses'])->name('find-houses');
    Route::post('/request-house', [TenantViewController::class, 'requestHouse'])->name('request-house');
    Route::get('/assigned-houses', [TenantViewController::class, 'viewAssignedHouses'])->name('assigned-houses');
    
    // Properties routes
    Route::get('/properties/{house}', [TenantViewController::class, 'showProperty'])->name('properties.show');
    
    // Reports
    Route::post('/reports', [TenantController::class, 'storeReport'])->name('reports.store');
    Route::get('/reports', [TenantController::class, 'showReports'])->name('reports.index');
    Route::get('/properties/rooms/{room}/items', [TenantController::class, 'getRoomItems'])->name('properties.rooms.items');
}); // Added the missing closing brace here

// Add this route for general dashboard redirection
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->isLandlord()) {
        return redirect()->route('landlord.dashboard');
    } elseif ($user->isTenant()) {
        return redirect()->route('tenant.dashboard');
    } elseif ($user->isContractor()) {
        return redirect()->route('contractor.dashboard');
    }
    
    return redirect('/');
})->name('dashboard');

 