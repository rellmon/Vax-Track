<?php
// Simple Laravel Mail test without SwiftMailer
require_once __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VaccTrack Mail Test (Using Laravel Facades) ===\n\n";

// Check environment variables
echo "1. Environment:\n";
echo "   APP_ENV: " . config('app.env') . "\n";
echo "   MAIL_MAILER: " . config('mail.default') . "\n";
echo "   MAIL_HOST: " . config('mail.mailers.smtp.host') . "\n";
echo "   MAIL_FROM_ADDRESS: " . config('mail.from.address') . "\n";
echo "\n";

// Try sending with Laravel's Mail facade
echo "2. Attempting to send email...\n";
try {
    $result = \Illuminate\Support\Facades\Mail::raw(
        'Test email from VaccTrack - ' . now(),
        function ($message) {
            $message->to('rellmontezor@gmail.com')
                    ->subject('VaccTrack Email Test');
        }
    );
    
    echo "   ✓ Email sent successfully!\n";
    echo "   Result type: " . get_class($result) . "\n";
} catch (\Exception $e) {
    echo "   ✗ Email send FAILED\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "   Exception: " . get_class($e) . "\n";
}

echo "\n3. Check Laravel logs for errors:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $lines = array_slice(file($logFile), -20);
    foreach ($lines as $line) {
        echo trim($line) . "\n";
    }
} else {
    echo "   Log file not found at: $logFile\n";
}
