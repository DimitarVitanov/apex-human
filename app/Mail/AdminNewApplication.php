<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewApplication extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function build(): self
    {
        return $this->subject('New Application — ' . $this->application->full_name)
            ->view('emails.admin-new-application', [
                'application' => $this->application,
            ]);
    }
}
