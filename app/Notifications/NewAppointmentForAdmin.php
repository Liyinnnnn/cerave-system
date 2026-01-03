<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentForAdmin extends Notification implements ShouldQueue
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
            ->subject('New Appointment Request - Action Required')
            ->greeting('Hello Admin!')
            ->line('A new appointment request has been submitted.')
            ->line('**Details:**')
            ->line('Name: ' . $this->appointment->name)
            ->line('Email: ' . $this->appointment->email)
            ->line('Phone: ' . $this->appointment->phone)
            ->line('Date: ' . $this->appointment->preferred_date)
            ->line('Time: ' . $this->appointment->preferred_time)
            ->line('Type: ' . ucfirst($this->appointment->consultation_type))
            ->line('Concerns: ' . ($this->appointment->concerns ?? 'None specified'))
            ->action('Review & Confirm', route('appointments.show', $this->appointment))
            ->line('Please review and confirm this appointment.');
    }

    public function toArray($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'New appointment request from ' . $this->appointment->name,
            'customer_name' => $this->appointment->name,
            'preferred_date' => $this->appointment->preferred_date,
        ];
    }
}
