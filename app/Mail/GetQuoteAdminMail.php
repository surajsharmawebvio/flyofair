<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GetQuoteAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'New quote request - ' . strtoupper($this->data['tripType'] ?? '');

        return $this->subject($subject)
                    ->view('emails.get_quote')
                    ->with(['data' => $this->data, 'recipient' => 'admin']);
    }
}
