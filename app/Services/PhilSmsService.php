<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendSmsJob;
use App\Models\SmsLog;

class PhilSmsService
{
    protected string $apiToken;
    protected string $senderName;
    protected string $apiUrl = 'https://dashboard.philsms.com/api/v3/sms/send';

    public function __construct()
    {
        $this->apiToken   = config('services.philsms.api_token', '');
        $this->senderName = config('services.philsms.sender_name', 'VaccTrack');

        Log::debug('PhilSmsService constructed', [
            'api_token_length' => strlen($this->apiToken),
            'api_token_prefix' => substr($this->apiToken, 0, 6) . '...',
            'sender_name'      => $this->senderName,
        ]);

        if (empty($this->apiToken)) {
            Log::error('PhilSMS: PHIL_SMS_API_TOKEN is empty — check your .env and run: php artisan config:clear');
        }
    }

    /**
     * Queue an SMS for sending with retry logic.
     */
    public function queueSms(string $phoneNumber, string $message, array $context = []): ?SmsLog
    {
        try {
            $smsLog = SmsLog::create([
                'phone_number' => $phoneNumber,
                'message'      => $message,
                'status'       => 'queued',
                'context'      => $context, // Pass array directly — cast handles encoding
            ]);

            SendSmsJob::dispatch(
                $phoneNumber,
                $message,
                $smsLog->id,
                $this->senderName,
                $this->apiToken,
            );

            Log::info('SMS queued', [
                'phone'      => $phoneNumber,
                'sms_log_id' => $smsLog->id,
                'context'    => $context,
            ]);

            return $smsLog;
        } catch (\Exception $e) {
            Log::error('Failed to queue SMS', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Send an SMS immediately (synchronous, no queue).
     * Use queueSms() in production for retry support.
     */
    public function sendSms(string $phoneNumber, string $message): ?array
    {
        if (empty($this->apiToken)) {
            Log::error('PhilSMS: Cannot send — API token is empty');
            return null;
        }

        $formattedPhone = $this->formatPhoneNumber($phoneNumber);

        Log::info('Sending SMS via PhilSMS (sync)', [
            'original_phone' => $phoneNumber,
            'formatted_phone' => $formattedPhone,
            'sender'         => $this->senderName,
        ]);

        try {
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiToken,
                    'Accept'        => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'recipient' => $formattedPhone,
                    'message'   => $message,
                    'sender_id' => $this->senderName,
                ]);

            $data = $response->json();

            Log::info('PhilSMS API response', [
                'http_status'   => $response->status(),
                'response_data' => $data,
            ]);

            if (is_array($data) && ($data['status'] ?? '') === 'success') {
                return $data;
            }

            Log::error('PhilSMS returned non-success', [
                'http_status'     => $response->status(),
                'api_status'      => $data['status'] ?? 'unknown',
                'api_message'     => $data['message'] ?? 'no message',
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('PhilSMS exception: ' . $e->getMessage(), [
                'phone' => $phoneNumber,
            ]);
            return null;
        }
    }

    protected function formatPhoneNumber(string $phoneNumber): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $phoneNumber);

        if (str_starts_with($phone, '+63') || str_starts_with($phone, '63')) {
            return str_replace('+', '', $phone);
        }

        if (str_starts_with($phone, '0')) {
            return '63' . substr($phone, 1);
        }

        return $phone;
    }
}