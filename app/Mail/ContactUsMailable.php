<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.username'))
            ->view('emails.contact-us-mail')
            ->text('emails.plain.contact-us-mail')
            ->subject('New Message from '.$this->data['contactEmail'])
            ->with([
                'contactName' => $this->data['contactName'],
                'contactEmail' => $this->data['contactEmail'],
                'contactMessage' => $this->data['contactMessage']
            ]);
    }
}
