<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact) {}

    public function build(): self
    {
        return $this->subject('We Got Your Message — Apex Human')
            ->view('emails.contact-auto-reply', [
                'contact' => $this->contact,
            ]);
    }
}
