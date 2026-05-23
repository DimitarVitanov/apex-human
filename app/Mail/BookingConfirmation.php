<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public Application $application,
        public string $meetLink,
    ) {}

    public function build(): self
    {
        return $this->subject('Call Booked — Apex Human')
            ->view('emails.booking-confirmation', [
                'booking' => $this->booking,
                'application' => $this->application,
                'meetLink' => $this->meetLink,
            ]);
    }
}
