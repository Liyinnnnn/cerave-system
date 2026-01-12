<?php

namespace App\Notifications;

use App\Models\DrCSession;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ConsultationReportCompleted extends Notification
{
    use Queueable;

    public function __construct(
        public DrCSession|Appointment $consultation,
        public string $reportUrl
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $consultationType = $this->consultation instanceof DrCSession ? 'Dr. C' : 'Consultant';
        $consultantName = $this->consultation instanceof DrCSession 
            ? 'Dr. C - AI Skincare Advisor' 
            : $this->consultation->consultant->name;

        return (new MailMessage)
            ->subject('Your Consultation Report is Ready')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your skincare consultation report with **' . $consultantName . '** is now ready.')
            ->line('Review your personalized skincare recommendations and product suggestions.')
            ->action('View Report', $this->reportUrl)
            ->line('Thank you for choosing CeraVe for your skincare journey!');
    }

    public function toArray(object $notifiable): array
    {
        $consultationType = $this->consultation instanceof DrCSession ? 'Dr. C' : 'Consultant';
        $consultantName = $this->consultation instanceof DrCSession 
            ? 'Dr. C - AI Skincare Advisor' 
            : $this->consultation->consultant->name;

        return [
            'title' => 'Consultation Report Ready',
            'message' => 'Your consultation report with ' . $consultantName . ' is now available.',
            'type' => 'consultation_report',
            'consultation_id' => $this->consultation->id,
            'consultation_type' => get_class($this->consultation),
            'report_url' => $this->reportUrl,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
