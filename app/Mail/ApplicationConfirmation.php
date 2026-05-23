<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function build(): self
    {
        $bookingUrl = url('/apply/book?token=' . $this->application->booking_token);

        return $this->subject('Application Received — Apex Human')
            ->view('emails.application-confirmation', [
                'application' => $this->application,
                'bookingUrl' => $bookingUrl,
            ]);
    }
}
