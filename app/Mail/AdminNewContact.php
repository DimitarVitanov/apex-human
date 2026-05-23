<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewContact extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contact $contact) {}

    public function build(): self
    {
        return $this->subject('New Contact — ' . $this->contact->name)
            ->view('emails.admin-new-contact', [
                'contact' => $this->contact,
            ]);
    }
}
