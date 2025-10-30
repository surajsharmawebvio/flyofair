<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\GetQuoteUserMail;
use App\Mail\GetQuoteAdminMail;

class SendGetQuoteEmails implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // send to user
        if (!empty($this->data['email'])) {
            Mail::to($this->data['email'])->send(new GetQuoteUserMail($this->data));
        }

        // small delay (Mailtrap allows only 1 email/sec in free tier)
        sleep(2);

        // send to admin
        $adminEmail = env('ADMIN_EMAIL', config('mail.from.address'));
        if (!empty($adminEmail)) {
            Mail::to($adminEmail)->send(new GetQuoteAdminMail($this->data));
        }
    }
}
