<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class JobApplicationNotification extends Notification
{
    use Queueable;

    protected $jobApplication;
    protected $sender;

    public function __construct($jobApplication, $sender)
    {
        $this->jobApplication = $jobApplication;
        $this->sender = $sender; // Отправитель уведомления
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new job application!',
            'application_id' => $this->jobApplication->id,
            'job_title' => $this->jobApplication->jobAd->title,
            'sender_name' => $this->sender->name,
            'sender_id' => $this->sender->id,
        ];
    }
}


