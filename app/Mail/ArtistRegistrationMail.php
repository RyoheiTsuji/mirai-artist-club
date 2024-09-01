<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArtistRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registrationUrl;

    /**
     * Create a new message instance.
     *
     * @param string $registrationUrl
     * @return void
     */
    public function __construct($registrationUrl)
    {
        $this->registrationUrl = $registrationUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.artist_registration')
                    ->subject('Complete Your Artist Registration')
                    ->with([
                        'registrationUrl' => $this->registrationUrl,
                    ]);
    }
}
