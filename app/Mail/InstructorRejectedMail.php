<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InstructorRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $reason;

    public function __construct($name, $reason)
    {
        $this->name = $name;
        $this->reason = $reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Update regarding your Instructor Application - TechTought',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.instructor_rejected',
        );
    }
}
