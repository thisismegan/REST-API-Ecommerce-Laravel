<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;


class MailVerify extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(protected $token)
    {
        $this->token = $token;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Email Verification'
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {

        return new Content(
            view: 'ViewMailVerify',
            with: ['token' => $this->token]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
