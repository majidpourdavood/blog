<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmail extends Notification
{
    use Queueable;
    public $dataNotify;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($dataNotify)
    {
        $this->dataNotify = $dataNotify;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = $this->dataNotify->url;
        $titleEmail = $this->dataNotify->titleEmail;
        $title = $this->dataNotify->title;
        $description = $this->dataNotify->description;
        $body = $this->dataNotify->body;
        $colorBtn = $this->dataNotify->colorBtn;
        $textBtn = $this->dataNotify->textBtn;

        return (new MailMessage)
            ->subject($titleEmail)
            ->markdown('mail.sendEmail', [
                'url' => $url,
                'colorBtn' => $colorBtn,
                'textBtn' => $textBtn,
                'title' => $title,
                'description' => $description,
                'body' => $body,
            ]);
    }

}
