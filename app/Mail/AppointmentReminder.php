<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Schedule;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Schedule $schedule
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $childName = $this->schedule->child->first_name . ' ' . $this->schedule->child->last_name;
        $vaccineName = $this->schedule->vaccine->name ?? 'Vaccine';

        return new Envelope(
            subject: "Reminder: Vaccination Appointment Tomorrow - {$childName} ({$vaccineName})",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-reminder',
            with: [
                'schedule' => $this->schedule,
                'child' => $this->schedule->child,
                'parent' => $this->schedule->child->parent,
                'vaccine' => $this->schedule->vaccine,
                'appUrl' => config('app.url'),
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
