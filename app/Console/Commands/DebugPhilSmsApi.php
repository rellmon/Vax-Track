<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DebugPhilSmsApi extends Command
{
    protected $signature = 'sms:debug';
    protected $description = 'Debug PhilSMS API connection';

    public function handle()
    {
        $apiToken = env('PHIL_SMS_API_TOKEN');
        $senderName = env('PHIL_SMS_SENDER_NAME');
        $phone = '639952493951';
        $message = 'Test SMS';

        $this->info("Testing PhilSMS API:");
        $this->info("API Token: " . substr($apiToken, 0, 10) . "...");
        $this->info("Sender: $senderName");
        $this->info("Phone: $phone");
        $this->info("");

        // Test PhilSMS endpoint
        $this->info("Testing https://dashboard.philsms.com/api/v3/sms/send");
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Accept' => 'application/json',
            ])->post('https://dashboard.philsms.com/api/v3/sms/send', [
                'recipient' => $phone,
                'message' => $message,
                'sender_id' => $senderName,
            ]);
            $this->info("Status: " . $response->status());
            $this->info("Response: " . $response->body());
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
