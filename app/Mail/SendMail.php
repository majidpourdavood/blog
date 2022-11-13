<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $dataNotify;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($dataNotify)
    {
        $this->dataNotify = $dataNotify;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = $this->dataNotify->url;
        $titleEmail = $this->dataNotify->titleEmail;
        $title = $this->dataNotify->title;
        $description = $this->dataNotify->description;
        $body = $this->dataNotify->body;
        $colorBtn = $this->dataNotify->colorBtn;
        $textBtn = $this->dataNotify->textBtn;

        return
            $this->subject($titleEmail)
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
