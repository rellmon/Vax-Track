<?php

Route::get('/api/health', function () {
    return response()->json(['status' => 'ok']);
});

// Diagnostic Routes (for troubleshooting)
Route::prefix('/diagnostic')->group(function () {
    Route::get('/mail-config', [DiagnosticController::class, 'testMail']);
    Route::get('/smtp-connection', [DiagnosticController::class, 'testSmtpConnection']);
    Route::get('/test-email', [DiagnosticController::class, 'sendTestEmail']);
});

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\VaccineController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ClinicSettingController;
use App\Http\Controllers\DiagnosticController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\VaccineInventoryController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\ClinicSettingsController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\EmailNotificationsController;
use App\Http\Controllers\Admin\SmsTemplatesController;
use App\Http\Controllers\Admin\ScheduledReportsController;
use App\Http\Controllers\Admin\VaccinationCoverageController;
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

// Admin routes (Phase 1)
Route::middleware('admin.auth')->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Audit & Activity Logging
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->name('audit-logs.show');
    Route::get('/audit-logs/export', [AuditLogController::class, 'export'])->name('audit-logs.export');
    Route::get('/api/audit-logs/summary', [AuditLogController::class, 'activitySummary'])->name('audit-logs.summary');

    // Financial Management
    Route::get('/financial/dashboard', [FinancialController::class, 'dashboard'])->name('financial.dashboard');
    Route::get('/financial/payments/{payment}', [FinancialController::class, 'paymentDetails'])->name('financial.payment-details');
    Route::post('/financial/payments/{payment}/status', [FinancialController::class, 'updatePaymentStatus'])->name('financial.payment-status');
    Route::get('/financial/report/download', [FinancialController::class, 'downloadReport'])->name('financial.report.download');
    Route::get('/api/financial/summary', [FinancialController::class, 'summary'])->name('financial.summary');

    // Vaccine Inventory
    Route::get('/vaccine-inventory/dashboard', [VaccineInventoryController::class, 'dashboard'])->name('vaccine-inventory.dashboard');
    Route::get('/vaccine-inventory/{vaccine}', [VaccineInventoryController::class, 'show'])->name('vaccine-inventory.show');
    Route::post('/vaccine-inventory/{vaccine}/stock', [VaccineInventoryController::class, 'updateStock'])->name('vaccine-inventory.stock');
    Route::get('/vaccine-inventory/alerts/low-stock', [VaccineInventoryController::class, 'lowStockAlert'])->name('vaccine-inventory.alerts');
    Route::get('/vaccine-inventory/report/download', [VaccineInventoryController::class, 'inventoryReport'])->name('vaccine-inventory.report');
    Route::get('/api/vaccine-inventory/summary', [VaccineInventoryController::class, 'summary'])->name('vaccine-inventory.summary');

    // Staff Management
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/{user}', [StaffController::class, 'show'])->name('staff.show');
    Route::get('/staff/{user}/edit', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{user}', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/staff/{user}/reset-password', [StaffController::class, 'resetPassword'])->name('staff.reset-password');
    Route::post('/staff/{user}/deactivate', [StaffController::class, 'deactivate'])->name('staff.deactivate');
    Route::post('/staff/{user}/reactivate', [StaffController::class, 'reactivate'])->name('staff.reactivate');
    Route::get('/staff/report/performance', [StaffController::class, 'performanceReport'])->name('staff.report.performance');
    Route::get('/api/staff/summary', [StaffController::class, 'summary'])->name('staff.summary');

    // Phase 2: Clinic Settings
    Route::get('/clinic-settings', [ClinicSettingsController::class, 'edit'])->name('clinic-settings.edit');
    Route::post('/clinic-settings', [ClinicSettingsController::class, 'update'])->name('clinic-settings.update');
    Route::get('/api/clinic-settings/summary', [ClinicSettingsController::class, 'summary'])->name('clinic-settings.summary');

    // Phase 2: Advanced Analytics
    Route::get('/analytics', [AnalyticsController::class, 'dashboard'])->name('analytics.dashboard');
    Route::get('/api/analytics/chart', [AnalyticsController::class, 'chartData'])->name('analytics.chart');

    // Phase 2: Email Notifications
    Route::get('/email-notifications', [EmailNotificationsController::class, 'index'])->name('email-notifications.index');
    Route::get('/email-notifications/create', [EmailNotificationsController::class, 'create'])->name('email-notifications.create');
    Route::post('/email-notifications', [EmailNotificationsController::class, 'store'])->name('email-notifications.store');
    Route::get('/email-notifications/{emailTemplate}/edit', [EmailNotificationsController::class, 'edit'])->name('email-notifications.edit');
    Route::put('/email-notifications/{emailTemplate}', [EmailNotificationsController::class, 'update'])->name('email-notifications.update');
    Route::delete('/email-notifications/{emailTemplate}', [EmailNotificationsController::class, 'destroy'])->name('email-notifications.destroy');
    Route::post('/email-notifications/{emailTemplate}/test', [EmailNotificationsController::class, 'test'])->name('email-notifications.test');
    Route::get('/api/email-notifications/variables', [EmailNotificationsController::class, 'variables'])->name('email-notifications.variables');

    // Phase 2: SMS Templates
    Route::get('/sms-templates', [SmsTemplatesController::class, 'index'])->name('sms-templates.index');
    Route::get('/sms-templates/create', [SmsTemplatesController::class, 'create'])->name('sms-templates.create');
    Route::post('/sms-templates', [SmsTemplatesController::class, 'store'])->name('sms-templates.store');
    Route::get('/sms-templates/{smsTemplate}/edit', [SmsTemplatesController::class, 'edit'])->name('sms-templates.edit');
    Route::put('/sms-templates/{smsTemplate}', [SmsTemplatesController::class, 'update'])->name('sms-templates.update');
    Route::delete('/sms-templates/{smsTemplate}', [SmsTemplatesController::class, 'destroy'])->name('sms-templates.destroy');
    Route::post('/sms-templates/{smsTemplate}/test', [SmsTemplatesController::class, 'test'])->name('sms-templates.test');
    Route::post('/api/sms-templates/character-count', [SmsTemplatesController::class, 'characterCount'])->name('sms-templates.character-count');
    Route::get('/api/sms-templates/variables', [SmsTemplatesController::class, 'variables'])->name('sms-templates.variables');

    // Phase 2: Scheduled Reports
    Route::get('/scheduled-reports', [ScheduledReportsController::class, 'index'])->name('scheduled-reports.index');
    Route::get('/scheduled-reports/create', [ScheduledReportsController::class, 'create'])->name('scheduled-reports.create');
    Route::post('/scheduled-reports', [ScheduledReportsController::class, 'store'])->name('scheduled-reports.store');
    Route::get('/scheduled-reports/{scheduledReport}', [ScheduledReportsController::class, 'show'])->name('scheduled-reports.show');
    Route::get('/scheduled-reports/{scheduledReport}/edit', [ScheduledReportsController::class, 'edit'])->name('scheduled-reports.edit');
    Route::put('/scheduled-reports/{scheduledReport}', [ScheduledReportsController::class, 'update'])->name('scheduled-reports.update');
    Route::delete('/scheduled-reports/{scheduledReport}', [ScheduledReportsController::class, 'destroy'])->name('scheduled-reports.destroy');
    Route::post('/scheduled-reports/{scheduledReport}/test', [ScheduledReportsController::class, 'testRun'])->name('scheduled-reports.test');
    Route::get('/api/scheduled-reports/due', [ScheduledReportsController::class, 'dueReports'])->name('scheduled-reports.due');

    // Phase 2: Vaccination Coverage Reports
    Route::get('/vaccination-coverage', [VaccinationCoverageController::class, 'dashboard'])->name('vaccination-coverage.dashboard');
    Route::get('/vaccination-coverage/vaccine/{vaccine}', [VaccinationCoverageController::class, 'vaccine'])->name('vaccination-coverage.vaccine');
    Route::get('/vaccination-coverage/public-health', [VaccinationCoverageController::class, 'publicHealth'])->name('vaccination-coverage.public-health');
    Route::get('/vaccination-coverage/export', [VaccinationCoverageController::class, 'export'])->name('vaccination-coverage.export');
    Route::get('/api/vaccination-coverage/summary', [VaccinationCoverageController::class, 'summary'])->name('vaccination-coverage.summary');
});

// Public API routes
Route::get('/api/clinic-info', [ClinicSettingController::class, 'getInfo'])->name('api.clinic-info');
