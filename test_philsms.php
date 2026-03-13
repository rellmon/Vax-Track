<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PhilSmsService;
use Illuminate\Support\Facades\Log;

// Test SMS sending
$philSms = new PhilSmsService();

echo "=== PhilSMS Configuration ===\n";
echo "API Token: " . substr(env('PHIL_SMS_API_TOKEN', ''), 0, 10) . "...\n";
echo "Sender Name: " . env('PHIL_SMS_SENDER_NAME') . "\n";
echo "Test Phone: 09952493951\n";
echo "\n";

// Send test SMS
$message = "Testing SMS - This is a test message from VaccTrack";
echo "Sending test SMS...\n";
$response = $philSms->sendSms('09952493951', $message);

if ($response && is_array($response)) {
    if ($response['status'] === 'success') {
        echo "✓ SMS sent successfully!\n";
        echo "Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "✗ SMS sending failed\n";
        echo "Status: " . ($response['status'] ?? 'unknown') . "\n";
        echo "Message: " . ($response['message'] ?? 'No message') . "\n";
    }
} else {
    echo "✗ API returned null - Check logs for error details\n";
    echo "Check: D:/vacctrack/storage/logs/laravel.log\n";
}
