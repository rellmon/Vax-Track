<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetOtp;

class SendPasswordResetOtp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $email,
        public string $userType,
        public string $userName,
        public string $otpCode,
        public int $expiryMinutes = 10,
        public ?int $userId = null
    ) {
        $this->queue = 'default';
        $this->onConnection('database');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            \Illuminate\Support\Facades\Log::info('Processing SendPasswordResetOtp job', [
                'email' => $this->email,
                'user_type' => $this->userType,
                'user_id' => $this->userId,
                'mail_driver' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
            ]);

            Mail::to($this->email)->send(new PasswordResetOtp(
                userType: $this->userType,
                userName: $this->userName,
                otpCode: $this->otpCode,
                expiryMinutes: $this->expiryMinutes
            ));

            \Illuminate\Support\Facades\Log::info('✅ Password reset OTP email sent successfully', [
                'email' => $this->email,
                'user_type' => $this->userType,
                'user_id' => $this->userId,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('❌ Password reset OTP email FAILED in job', [
                'email' => $this->email,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
                'user_type' => $this->userType,
                'mail_config' => [
                    'driver' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                ],
            ]);

            // Rethrow to trigger job retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        \Illuminate\Support\Facades\Log::critical('❌ SendPasswordResetOtp job permanently failed', [
            'email' => $this->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
