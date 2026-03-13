<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ClinicSettingController;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Recovery
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot-password');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('auth.send-otp');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('auth.verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp.post');
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('auth.reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password.post');

// Doctor routes
Route::middleware('auth.doctor')->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');

    // Vaccines
    Route::get('/vaccines', [VaccineController::class, 'index'])->name('vaccines');
    Route::post('/vaccines', [VaccineController::class, 'store'])->name('vaccines.store');
    Route::get('/vaccines/{vaccine}/edit', [VaccineController::class, 'edit'])->name('vaccines.edit');
    Route::put('/vaccines/{vaccine}', [VaccineController::class, 'update'])->name('vaccines.update');
    Route::delete('/vaccines/{vaccine}', [VaccineController::class, 'destroy'])->name('vaccines.destroy');

    // Children
    Route::get('/children', [ChildController::class, 'index'])->name('children');
    Route::get('/children/create', [ChildController::class, 'create'])->name('children.create');
    Route::post('/children', [ChildController::class, 'store'])->name('children.store');
    Route::get('/children/create-existing-parent', [ChildController::class, 'createWithExistingParent'])->name('children.create-existing');
    Route::post('/children/store-existing-parent', [ChildController::class, 'storeWithExistingParent'])->name('children.store-existing');
    Route::get('/children/{child}', [ChildController::class, 'show'])->name('children.show');
    Route::get('/children/{child}/edit', [ChildController::class, 'edit'])->name('children.edit');
    Route::put('/children/{child}', [ChildController::class, 'update'])->name('children.update');
    Route::post('/children/{child}/add-vaccine', [ChildController::class, 'addVaccine'])->name('children.addVaccine');

    // Schedules
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedules');
    Route::post('/schedules', [ScheduleController::class, 'store'])->name('schedules.store');
    Route::put('/schedules/{schedule}/status', [ScheduleController::class, 'updateStatus'])->name('schedules.status');
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])->name('schedules.destroy');
    Route::post('/schedules/{schedule}/send-sms', [ScheduleController::class, 'sendSms'])->name('schedules.sms');
    Route::post('/schedules/sms-logs/clear', [ScheduleController::class, 'clearSmsLogs'])->name('schedules.sms-logs.clear');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::put('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.status');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('/payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');
    Route::get('/payments/report/print', [PaymentController::class, 'printReport'])->name('payments.report');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/generate', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
    Route::get('/reports/download', [ReportController::class, 'download'])->name('reports.download');

    // Clinic Settings
    Route::get('/settings', [ClinicSettingController::class, 'edit'])->name('settings');
    Route::put('/settings', [ClinicSettingController::class, 'update'])->name('settings.update');
});

// Parent routes
Route::middleware('auth.parent')->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('dashboard');
    Route::get('/schedules', [ParentController::class, 'schedules'])->name('schedules');
    Route::get('/records', [ParentController::class, 'records'])->name('records');
    Route::get('/records/print', [ParentController::class, 'printRecords'])->name('print-records');
    Route::get('/payments', [ParentController::class, 'payments'])->name('payments');
});

// Public API routes
Route::get('/api/clinic-info', [ClinicSettingController::class, 'getInfo'])->name('api.clinic-info');
