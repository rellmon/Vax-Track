<?php

namespace App\Console\Commands;

use App\Services\PhilSmsService;
use Illuminate\Console\Command;

class TestPhilSmsSms extends Command
{
    protected $signature = 'sms:test {phone}';
    protected $description = 'Test sending SMS via PhilSMS';

    public function handle()
    {
        $phone = $this->argument('phone');
        
        $this->info("Testing SMS to: $phone");
        
        $philSms = new PhilSmsService();
        $result = $philSms->sendSms($phone, 'VaccTrack Test SMS - ' . now());
        
        if ($result) {
            $this->info('✅ SMS sent successfully!');
            $this->info('Response: ' . json_encode($result));
        } else {
            $this->error('❌ SMS failed to send. Check storage/logs/laravel.log for details.');
        }
    }
}
