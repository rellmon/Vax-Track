<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetOtp;
use App\Jobs\SendPasswordResetOtp;

class SmsOtp extends Model
{
    protected $table = 'sms_otps';
    protected $fillable = [
        'email',
        'otp_code',
        'user_type',
        'user_id',
        'purpose',
        'attempts',
        'expires_at',
        'used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public static function generateAndSend(string $email, string $userType, ?int $userId, string $purpose = 'password_reset'): ?self
    {
        // Invalidate previous OTPs for this email
        self::where('email', $email)
            ->where('purpose', $purpose)
            ->where('used', false)
            ->update(['used' => true]);

        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $smsOtp = self::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'user_type' => $userType,
            'user_id' => $userId,
            'purpose' => $purpose,
            'attempts' => 0,
            'expires_at' => Carbon::now()->addMinutes(10),
            'used' => false,
        ]);

        // Get user name based on user type
        $userName = 'User';
        if ($userType === 'doctor' && $userId) {
            $user = User::find($userId);
            $userName = $user?->name ?? 'Doctor';
        } elseif ($userType === 'parent' && $userId) {
            $parent = ParentGuardian::find($userId);
            $userName = $parent?->name ?? 'Parent';
        }

        // Send password reset email synchronously (not queued)
        try {
            \Illuminate\Support\Facades\Log::info('Sending password reset email directly (sync)', [
                'email' => $email,
                'mailer' => config('mail.default'),
                'smtp_host' => config('mail.mailers.smtp.host'),
                'smtp_port' => config('mail.mailers.smtp.port'),
                'smtp_encryption' => config('mail.mailers.smtp.encryption'),
                'from_address' => config('mail.from.address'),
            ]);
            
            // Send directly without queue
            Mail::to($email)->send(new PasswordResetOtp(
                userType: $userType,
                userName: $userName,
                otpCode: $otpCode,
                expiryMinutes: 10
            ));
            
            \Illuminate\Support\Facades\Log::info('✅ Password reset OTP email sent successfully (sync)', [
                'email' => $email,
                'user_type' => $userType,
                'user_id' => $userId,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('❌ Password reset OTP email FAILED (sync)', [
                'email' => $email,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Don't rethrow - let the OTP still be created even if email fails
        }

        return $smsOtp;
    }

    public function isValid(): bool
    {
        return !$this->used && $this->expires_at > now() && $this->attempts < 3;
    }

    public function verify(string $otpCode): bool
    {
        $this->attempts++;
        $this->save();

        if ($this->attempts > 3) {
            $this->used = true;
            $this->save();
            return false;
        }

        if ($this->otp_code === $otpCode && $this->isValid()) {
            $this->used = true;
            $this->save();
            return true;
        }

        return false;
    }
}
