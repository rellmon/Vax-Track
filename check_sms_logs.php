<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\SmsLog;
use Illuminate\Support\Facades\DB;

// Check latest SMS logs
echo "=== Latest SMS Logs ===\n";
$logs = SmsLog::latest()->limit(5)->get();
foreach ($logs as $log) {
    echo "\nID: " . $log->id . "\n";
    echo "Phone: " . $log->phone_number . "\n";
    echo "Message: " . substr($log->message, 0, 50) . "...\n";
    echo "Status: " . $log->status . "\n";
    echo "Created: " . $log->created_at . "\n";
    if ($log->error_message) {
        echo "Error: " . $log->error_message . "\n";
    }
    if ($log->response) {
        echo "Response: " . substr($log->response, 0, 100) . "...\n";
    }
}

// Check if jobs table exists and has pending jobs
echo "\n\n=== Pending Jobs ===\n";
try {
    $jobs = DB::table('jobs')->where('attempts', '<', 5)->limit(5)->get();
    foreach ($jobs as $job) {
        echo "Job ID: " . $job->id . ", Attempts: " . $job->attempts . "\n";
    }
} catch (\Exception $e) {
    echo "Jobs table error: " . $e->getMessage() . "\n";
}

// Check environment config
echo "\n\n=== Configuration ===\n";
echo "QUEUE_CONNECTION: " . env('QUEUE_CONNECTION') . "\n";
echo "PHIL_SMS_API_TOKEN: " . substr(env('PHIL_SMS_API_TOKEN', ''), 0, 10) . "...\n";
echo "PHIL_SMS_SENDER_NAME: " . env('PHIL_SMS_SENDER_NAME') . "\n";
