<?php

use Illuminate\Support\Facades\Http;

// Test different possible PhilSMS endpoints
$apiToken = env('PHIL_SMS_API_TOKEN');
$phone = '639952493951';
$message = 'Test SMS';
$senderName = 'SamsonCruzClinic';

$endpoints = [
    'https://api.philsms.com/v1/sms/send' => ['api_token' => $apiToken, 'phone' => $phone, 'message' => $message, 'sender_name' => $senderName],
    'https://api.philsms.com/send' => ['api_token' => $apiToken, 'phone' => $phone, 'message' => $message, 'sender_name' => $senderName],
    'https://api.philsms.com/sms/send' => ['api_token' => $apiToken, 'phone' => $phone, 'message' => $message, 'sender_name' => $senderName],
    'https://api.philsms.com/api/send' => ['api_token' => $apiToken, 'phone' => $phone, 'message' => $message, 'sender_name' => $senderName],
];

echo "Testing PhilSMS endpoints:\n";
echo str_repeat('=', 80) . "\n\n";

foreach ($endpoints as $endpoint => $params) {
    echo "Testing: $endpoint\n";
    try {
        $response = Http::timeout(5)->post($endpoint, $params);
        echo "Status: " . $response->status() . "\n";
        if (!$response->successful()) {
            echo "Response (first 200 chars): " . substr($response->body(), 0, 200) . "\n";
        } else {
            echo "Success! Response: " . $response->body() . "\n";
        }
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo str_repeat('-', 80) . "\n\n";
}
?>
