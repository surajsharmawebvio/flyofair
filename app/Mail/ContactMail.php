<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contactData;
    public $isAdminEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($contactData, $isAdminEmail = false)
    {
        $this->contactData = $contactData;
        $this->isAdminEmail = $isAdminEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdminEmail
            ? 'New Contact Form Submission - FlyOFair'
            : 'Thank you for contacting FlyOFair';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = $this->isAdminEmail ? 'emails.contact-admin' : 'emails.contact-user';

        return new Content(
            view: $view,
            with: [
                'contactData' => $this->contactData,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
