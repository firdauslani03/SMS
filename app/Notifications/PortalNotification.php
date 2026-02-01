<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PortalNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $actionUrl;

    public function __construct($message, $actionUrl = '#')
    {
        $this->message = $message;
        $this->actionUrl = $actionUrl;
    }

    public function via($notifiable)
    {
        return ['database']; // Store in database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->actionUrl,
            'icon' => 'info', // You can make this dynamic later
        ];
    }
}