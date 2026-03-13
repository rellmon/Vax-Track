<?php
require 'vendor/autoload.php';

$apiToken = "1770|EhMvVudwzaZjQP94asr8OXNiIcd2S2wFgdKwuFxKb003c689";
$senderName = "PhilSMS";
$phoneNumber = "+639952493951";

// Test 1: Simple message
$message1 = "Test message from VaccTrack";

// Test 2: Message with special UTF-8 characters (like the em-dash)
$message2 = "Reminder: Test's Hepatitis B appointment is on March 13, 2026 at 09:00. — VaccTrack Clinic";

echo "Testing PhilSMS API - Testing UTF-8 Characters\n";
echo "==========================================\n";

function testApi($message, $testName) {
    $apiToken = "1770|EhMvVudwzaZjQP94asr8OXNiIcd2S2wFgdKwuFxKb003c689";
    $senderName = "PhilSMS";
    $phoneNumber = "+639952493951";
    
    echo "\n$testName\n";
    echo "Message: " . substr($message, 0, 50) . "...\n";
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://dashboard.philsms.com/api/v3/sms/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            "recipient" => $phoneNumber,
            "message" => $message,
            "sender_id" => $senderName,
        ]),
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $apiToken,
            "Content-Type: application/json",
            "Accept: application/json",
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);
    
    echo "HTTP Status: $httpCode\n";
    
    $responseData = json_decode($response, true);
    if ($responseData && isset($responseData['status'])) {
        echo "Status: " . $responseData['status'] . "\n";
        echo "Message: " . $responseData['message'] . "\n";
    } else {
        echo "Response: " . substr($response, 0, 100) . "\n";
    }
}

testApi($message1, "Test 1: Simple ASCII message");
testApi($message2, "Test 2: Message with UTF-8 em-dash character");

