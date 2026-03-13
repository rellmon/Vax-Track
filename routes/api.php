<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes (no authentication required)
Route::middleware('throttle:60,1')->group(function () {
    // Authentication
    Route::post('/auth/login', [ApiController::class, 'authenticate']);
    
    // Public clinic information
    Route::get('/clinic-info', [ApiController::class, 'getClinicInfo']);
});

// Protected API routes (with API token validation)
Route::middleware('throttle:60,1')->group(function () {
    // Parent registration (public)
    Route::post('/parents/register', [ApiController::class, 'registerParent']);
    
    // Parent endpoints (should validate parent token)
    Route::prefix('parents/{parentId}')->group(function () {
        Route::get('/children', [ApiController::class, 'getChildren']);
        Route::get('/appointments', [ApiController::class, 'getAppointments']);
    });
    
    // Child endpoints
    Route::prefix('children/{childId}')->group(function () {
        Route::get('/records', [ApiController::class, 'getChildRecords']);
    });
    
    // Appointment endpoints
    Route::prefix('appointments')->group(function () {
        Route::post('/', [ApiController::class, 'createAppointment']);
        Route::put('/{appointmentId}', [ApiController::class, 'updateAppointment']);
        Route::delete('/{appointmentId}', [ApiController::class, 'cancelAppointment']);
    });
});
