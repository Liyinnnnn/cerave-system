<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationReportReady extends Mailable
{
    use Queueable, SerializesModels;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function build()
    {
        return $this
            ->subject('Your Consultation Report is Ready - CeraVe Skincare')
            ->replyTo('noreply@cerave.com', 'CeraVe Team')
            ->view('emails.consultation_report_ready');
    }
}
