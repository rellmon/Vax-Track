<?php
require_once __DIR__ . '/vendor/autoload.php';

$apiToken = '1770|EhMvVudwzaZjQP94asr8OXNiIcd2S2wFgdKwuFxKb003c689';

echo "Testing PhilSMS API Connection...\n";
echo "API Token: " . substr($apiToken, 0, 20) . "...\n\n";

$ch = curl_init('https://dashboard.philsms.com/api/v3/sms/send');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $apiToken,
        'Accept: application/json',
        'Content-Type: application/json',
    ],
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'recipient' => '639952493951',
        'message' => 'Test SMS',
        'sender_id' => 'PhilSMS',
    ]),
    CURLOPT_TIMEOUT => 10,
    CURLOPT_VERBOSE => true,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "Response: " . $response . "\n";
if ($error) {
    echo "Error: " . $error . "\n";
}

if ($httpCode === 403) {
    echo "\n⚠️  403 FORBIDDEN - Your API token is rejected by PhilSMS.\n";
    echo "Possible causes:\n";
    echo "1. API token has expired\n";
    echo "2. Sender name 'PhilSMS' is not registered/approved\n";
    echo "3. PhilSMS account is suspended\n";
    echo "4. IP address may be blocked\n";
}
