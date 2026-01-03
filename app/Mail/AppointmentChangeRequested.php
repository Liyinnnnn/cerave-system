<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentChangeRequested extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Appointment $appointment,
        public ?string $requestedDate = null,
        public ?string $requestedTime = null,
        public ?string $reason = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Change Request Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.appointment-change-requested',
            with: [
                'appointment' => $this->appointment,
                'requestedDate' => $this->requestedDate,
                'requestedTime' => $this->requestedTime,
                'reason' => $this->reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
