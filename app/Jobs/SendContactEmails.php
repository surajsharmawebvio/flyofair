<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

class SendContactEmails implements ShouldQueue
{
    use Queueable;

    protected $contactData;

    /**
     * Create a new job instance.
     */
    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to admin
        Mail::to(config('services.admin_email', 'surajkumarsharma123@gmail.com'))
            ->send(new ContactMail($this->contactData, true));

        // Send confirmation email to user
        Mail::to($this->contactData['email'])
            ->send(new ContactMail($this->contactData, false));
    }
}
