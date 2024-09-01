<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($inquiry,$name)
    {
        $this->inquiry = $inquiry;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('問い合わせを受け付けました')
            ->view('emails.inquiry_received')
            ->with([
                'name' => $this->name,
                'subject' => $this->inquiry->subject,
                'messageContent' => $this->inquiry->message,
            ]);
    }
}
