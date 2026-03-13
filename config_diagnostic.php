<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\PhilSmsService;

echo "=== Configuration Diagnostic ===\n\n";

// Check environment variables directly
echo "1. Environment Variables:\n";
echo "   PHIL_SMS_API_TOKEN: " . (env('PHIL_SMS_API_TOKEN') ? substr(env('PHIL_SMS_API_TOKEN'), 0, 15) . "..." : "NOT SET") . "\n";
echo "   PHIL_SMS_SENDER_NAME: " . (env('PHIL_SMS_SENDER_NAME') ?: "NOT SET") . "\n\n";

// Check config array
echo "2. Config Array:\n";
echo "   config('services.philsms.api_token'): " . (config('services.philsms.api_token') ? substr(config('services.philsms.api_token'), 0, 15) . "..." : "NOT SET") . "\n";
echo "   config('services.philsms.sender_name'): " . (config('services.philsms.sender_name') ?: "NOT SET") . "\n\n";

// Check what PhilSmsService actually gets
echo "3. PhilSmsService Instance:\n";
$service = new PhilSmsService();
$reflectionClass = new ReflectionClass($service);
$apiTokenProperty = $reflectionClass->getProperty('apiToken');
$apiTokenProperty->setAccessible(true);
$senderNameProperty = $reflectionClass->getProperty('senderName');
$senderNameProperty->setAccessible(true);

echo "   apiToken: " . (($apiTokenProperty->getValue($service)) ? substr($apiTokenProperty->getValue($service), 0, 15) . "..." : "NULL") . "\n";
echo "   senderName: " . ($senderNameProperty->getValue($service) ?: "NULL") . "\n\n";

// Test the service
echo "4. Attempting SMS Send:\n";
$result = $service->sendSms('09952493951', 'Configuration test from diagnostic');
if ($result && is_array($result)) {
    echo "   Status: " . ($result['status'] ?? 'unknown') . "\n";
    if ($result['status'] === 'success') {
        echo "   Message: " . ($result['message'] ?? '') . "\n";
    } else {
        echo "   Error: " . ($result['message'] ?? 'Unknown error') . "\n";
    }
} else {
    echo "   Result: NULL (API call failed)\n";
    echo "   Check laravel.log for details\n";
}
