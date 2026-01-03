<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;
    protected $oldStatus;

    public function __construct(Appointment $appointment, string $oldStatus)
    {
        $this->appointment = $appointment;
        $this->oldStatus = $oldStatus;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Appointment Status Updated - CeraVe Skincare')
            ->greeting('Hello ' . $this->appointment->name . '!');

        if ($this->appointment->status === 'confirmed') {
            $message->line('Great news! Your appointment has been **confirmed**.')
                ->line('**Appointment Details:**')
                ->line('Date: ' . $this->appointment->preferred_date)
                ->line('Time: ' . $this->appointment->preferred_time)
                ->line('Type: ' . ucfirst($this->appointment->consultation_type))
                ->line('Please arrive 5 minutes early for in-store consultations.');
        } elseif ($this->appointment->status === 'completed') {
            $message->line('Your appointment has been marked as **completed**.')
                ->line('Thank you for visiting CeraVe Skincare!')
                ->line('We hope you had a great experience.');
        } elseif ($this->appointment->status === 'cancelled') {
            $message->line('Your appointment has been **cancelled**.')
                ->line('If you would like to reschedule, please book a new appointment.');
        }

        return $message
            ->action('View Appointment', route('appointments.show', $this->appointment))
            ->line('Thank you for choosing CeraVe Skincare!');
    }

    public function toArray($notifiable): array
    {
        return [
            'appointment_id' => $this->appointment->id,
            'message' => 'Appointment status changed from ' . $this->oldStatus . ' to ' . $this->appointment->status,
            'old_status' => $this->oldStatus,
            'new_status' => $this->appointment->status,
        ];
    }
}
