<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

// Check if there's a schedule withchild data
$schedule = DB::table('schedules')
    ->join('children', 'schedules.child_id', '=', 'children.id')
    ->join('vaccines', 'schedules.vaccine_id', '=', 'vaccines.id')
    ->select('schedules.*', 'children.first_name', 'children.last_name', 'vaccines.name')
    ->latest('schedules.id')
    ->first();

if ($schedule) {
    echo "Found schedule:\n";
    echo "Child: {$schedule->first_name} {$schedule->last_name}\n";
    echo "Vaccine: {$schedule->name}\n";
    echo "Date: {$schedule->appointment_date} at {$schedule->appointment_time}\n";
    
    // Generate the new message format (without em-dash)
    $message = "Reminder: {$schedule->first_name} {$schedule->last_name}'s {$schedule->name} appointment is on " . 
               \Carbon\Carbon::parse($schedule->appointment_date)->format('F j, Y') . 
               " at {$schedule->appointment_time}. - VaccTrack Clinic";
    
    echo "\nNew message (without em-dash):\n";
    echo "$message\n\n";
    
    // Test with PhilSMS API
    $apiToken = "1770|EhMvVudwzaZjQP94asr8OXNiIcd2S2wFgdKwuFxKb003c689";
    $phoneNumber = "+639952493951";
    
    echo "Testing new message with PhilSMS API...\n";
    
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
            "sender_id" => "PhilSMS",
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
        echo "API Status: " . $responseData['status'] . "\n";
        echo "Message: " . $responseData['message'] . "\n";
    }
} else {
    echo "No schedules found in database\n";
}
