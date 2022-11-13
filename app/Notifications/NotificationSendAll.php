<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationSendAll extends Notification implements ShouldQueue
{
    use Queueable;
    protected $message;
    protected $link;
    protected $linkText;
    protected $class;
    protected $userSender;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $link,$linkText, $class,$userSender)
    {
        $this->message = $message;
        $this->link = $link;
        $this->linkText = $linkText;
        $this->class = $class;
        $this->userSender = $userSender;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'  ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'data' => $this->message,
            'user' => $notifiable,
            'link' => $this->link,
            'linkText' => $this->linkText,
            'class' => $this->class,
            'userSender' => $this->userSender,

        ];
    }


}
