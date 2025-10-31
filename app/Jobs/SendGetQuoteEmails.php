<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\GetQuoteUserMail;
use App\Mail\GetQuoteAdminMail;
use Exception;

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
        try {
            // Send to user
            if (!empty($this->data['email'])) {
                Mail::to($this->data['email'])->send(new GetQuoteUserMail($this->data));
            }

            // Send to admin
            $adminEmail = env('ADMIN_EMAIL', 'suraj.webvio@gmail.com');
            
            if (!empty($adminEmail)) {
                try {
                    Mail::to($adminEmail)->send(new GetQuoteAdminMail($this->data));
                } catch (Exception $e) {
                    report($e); // Using Laravel's report helper
                    throw $e;
                }
            } else {
                info('Admin email address is empty or invalid');
            }
        } catch (Exception $e) {
            report($e); // Using Laravel's report helper
            throw $e;
        }
    }
}
