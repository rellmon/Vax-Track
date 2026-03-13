<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SmsLog;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The maximum number of unhandled exceptions allowed before failing.
     */
    public int $maxExceptions = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 30;

    /**
     * Backoff in seconds between retries.
     */
    public function backoff(): array
    {
        return [60, 120, 300, 600, 1800];
    }

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $phoneNumber,
        public string $message,
        public ?int $smsLogId = null,
        public ?string $senderName = null,
        public ?string $apiToken = null,
    ) {
        // Capture configuration at job creation time so it's serialized with the job
        if (!$this->senderName) {
            $this->senderName = config('services.philsms.sender_name') ?? env('PHIL_SMS_SENDER_NAME', 'PhilSMS');
        }
        if (!$this->apiToken) {
            $this->apiToken = config('services.philsms.api_token') ?? env('PHIL_SMS_API_TOKEN');
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Validate API token before attempting
        if (!$this->apiToken) {
            Log::error('PhilSMS API Token not configured — cannot send SMS', [
                'phone' => $this->phoneNumber,
                'sms_log_id' => $this->smsLogId,
            ]);

            $this->updateLog('failed', 'API token not configured');

            // Don't retry if misconfigured
            $this->fail(new \Exception('PhilSMS API Token not configured'));
            return;
        }

        $formattedPhone = $this->formatPhoneNumber($this->phoneNumber);

        Log::info('Sending SMS via PhilSMS', [
            'original_phone' => $this->phoneNumber,
            'formatted_phone' => $formattedPhone,
            'message' => $this->message,
            'sender' => $this->senderName,
            'attempt' => $this->attempts(),
            'api_token_length' => strlen($this->apiToken),
            'api_token_prefix' => substr($this->apiToken, 0, 10) . '...',
        ]);

        // withoutVerifying() is needed on Windows where SSL CA bundles are often
        // missing, causing Laravel's HTTP client to fail with 403/SSL errors
        // even though the API works fine from curl.
        $authHeader = 'Bearer ' . $this->apiToken;
        
        $postData = [
            'recipient' => $formattedPhone,
            'message' => $this->message,
            'sender_id' => $this->senderName,
        ];
        
        Log::debug('HTTP Request Details', [
            'url' => 'https://dashboard.philsms.com/api/v3/sms/send',
            'auth_header_length' => strlen($authHeader),
            'auth_header_prefix' => substr($authHeader, 0, 15) . '...',
            'post_data' => $postData,
            'post_data_json' => json_encode($postData),
        ]);
        
        $response = Http::timeout(10)
            ->withoutVerifying()
            ->withHeaders([
                'Authorization' => $authHeader,
                'Accept' => 'application/json',
            ])
            ->post('https://dashboard.philsms.com/api/v3/sms/send', $postData);

        $responseData = $response->json();
        
        Log::debug('PhilSMS API Raw Response', [
            'http_status' => $response->status(),
            'raw_body' => $response->body(),
            'headers' => $response->headers(),
        ]);

        Log::info('PhilSMS API Response', [
            'http_status' => $response->status(),
            'response_data' => $responseData,
        ]);

        // PhilSMS may return 200 or a JSON status of "success"
        $isSuccess = is_array($responseData) && ($responseData['status'] === 'success' || $response->successful());

        if ($isSuccess) {
            $this->updateLog('sent', null, $responseData);

            Log::info('SMS sent successfully', [
                'phone' => $formattedPhone,
                'sms_log_id' => $this->smsLogId,
            ]);

            return;
        }

        // API returned a non-success response — throw so Laravel retries with backoff()
        $errorMessage = $responseData['message'] ?? ('HTTP ' . $response->status());

        Log::error('PhilSMS returned failure response', [
            'http_status' => $response->status(),
            'api_message' => $errorMessage,
            'phone' => $formattedPhone,
            'attempt' => $this->attempts(),
        ]);

        $this->updateLog('failed', $errorMessage);

        throw new \Exception('PhilSMS API error: ' . $errorMessage);
    }

    /**
     * Handle a job that has permanently failed (all retries exhausted).
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('SMS job permanently failed after all retries', [
            'phone' => $this->phoneNumber,
            'error' => $exception->getMessage(),
            'sms_log_id' => $this->smsLogId,
        ]);

        $this->updateLog('failed', 'Max retries reached: ' . $exception->getMessage());
    }

    /**
     * Update the SmsLog record.
     */
    private function updateLog(string $status, ?string $errorMessage = null, ?array $response = null): void
    {
        if (!$this->smsLogId) {
            return;
        }

        $smsLog = SmsLog::find($this->smsLogId);
        if (!$smsLog) {
            return;
        }

        $data = [
            'status' => $status,
            'retry_count' => $this->attempts(),
        ];

        if ($status === 'sent') {
            $data['sent_at'] = now();
            // Pass the array directly — SmsLog casts 'response' as array, no need for json_encode
            $data['response'] = $response;
        }

        if ($errorMessage) {
            $data['error_message'] = $errorMessage;
        }

        $smsLog->update($data);
    }

    /**
     * Format phone number to PhilSMS format (09XXXXXXXXX → 639XXXXXXXXX).
     */
    private function formatPhoneNumber(string $phoneNumber): string
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