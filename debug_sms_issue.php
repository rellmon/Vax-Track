<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SmsLog;
use App\Models\Schedule;
use App\Models\ParentGuardian;
use Illuminate\Support\Facades\DB;

echo "=== Latest SMS Logs ===\n";
$logs = SmsLog::latest()->limit(10)->get();
foreach ($logs as $log) {
    echo "\nID: " . $log->id . "\n";
    echo "Phone: " . $log->phone_number . "\n";
    echo "Status: " . $log->status . "\n";
    echo "Created: " . $log->created_at . "\n";
    if ($log->error_message) {
        echo "Error: " . $log->error_message . "\n";
    }
}

echo "\n\n=== Schedules with Parent Info ===\n";
$schedules = Schedule::with(['child', 'child.parent', 'vaccine'])
    ->latest('created_at')
    ->limit(5)
    ->get();

foreach ($schedules as $schedule) {
    echo "\nSchedule ID: " . $schedule->id . "\n";
    echo "Child: " . $schedule->child->first_name . " " . $schedule->child->last_name . "\n";
    echo "Vaccine: " . $schedule->vaccine->name . "\n";
    echo "Appointment: " . $schedule->appointment_date . " at " . $schedule->appointment_time . "\n";
    echo "SMS Sent Flag: " . ($schedule->sms_sent ? "Yes" : "No") . "\n";
    if ($schedule->child->parent) {
        echo "Parent Phone: " . ($schedule->child->parent->phone ?? "MISSING") . "\n";
    } else {
        echo "Parent: NOT LINKED\n";
    }
}

echo "\n\n=== Jobs Queue Status ===\n";
try {
    $jobs = DB::table('jobs')->get();
    echo "Total jobs in queue: " . count($jobs) . "\n";
    foreach ($jobs as $job) {
        echo "Job ID: " . $job->id . ", Attempts: " . $job->attempts . ", Queue: " . $job->queue . "\n";
    }
} catch (\Exception $e) {
    echo "Jobs table error: " . $e->getMessage() . "\n";
}

echo "\n\n=== Recent Log Entries ===\n";
$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = array_slice(file($logFile), -50);
    foreach ($lines as $line) {
        if (strpos($line, 'SMS') !== false || strpos($line, 'sms') !== false) {
            echo trim($line) . "\n";
        }
    }
}
