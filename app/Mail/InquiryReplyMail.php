<?php

// app/Mail/InquiryReplyMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Inquiry;

class InquiryReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;

    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    public function build()
    {
        return $this->subject('返信が届きました')
            ->view('emails.inquiry_reply')
            ->with([
                'inquiry' => $this->inquiry,
                'replyUrl' => url('/inquiry/reply/' . $this->inquiry->id), // 返信フォームのURL
            ]);
    }
}

