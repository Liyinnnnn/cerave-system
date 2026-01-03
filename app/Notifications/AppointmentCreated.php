<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Request Received - CeraVe Skincare')
            ->greeting('Hello ' . $this->appointment->name . '!')
            ->line('Thank you for booking a consultation with CeraVe Skincare.')
            ->line('**Appointment Details:**')
            ->line('Date: ' . $this->appointment->preferred_date)
            ->line('Time: ' . $this->appointment->preferred_time)
            ->line('Type: ' . ucfirst($this->appointment->consultation_type))
            ->line('Status: ' . ucfirst($this->appointment->status))
            ->line('We will review your request and contact you shortly to confirm your appointment.')
            ->action('View Appointment', route('appointments.show', $this->appointment))
            ->line('Thank you for choosing CeraVe Skincare!');
    }

    public function toArray($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'New appointment request received',
            'date' => $this->appointment->preferred_date,
            'time' => $this->appointment->preferred_time,
        ];
    }
}
