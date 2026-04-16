<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PasswordResetOtp extends Mailable
{
    /**
     * Password reset OTP email - sent immediately (not queued)
     * No Queueable trait since no queue worker on Railway
     */

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $userType,
        public string $userName,
        public string $otpCode,
        public int $expiryMinutes = 10
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset Code for VaccTrack - ' . strtoupper($this->userType),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-otp',
            with: [
                'userType' => $this->userType,
                'userName' => $this->userName,
                'otpCode' => $this->otpCode,
                'expiryMinutes' => $this->expiryMinutes,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
