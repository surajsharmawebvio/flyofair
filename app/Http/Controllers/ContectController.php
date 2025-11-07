<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Jobs\SendContactEmails;
use Illuminate\Support\Facades\Validator;

class ContectController extends Controller
{
    public function index()
    {
        return Inertia::render('Contact');
    }

    public function indexEs()
    {
        return Inertia::render('Contactanos');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contactData = $request->only(['name', 'email', 'phone', 'message']);

        // Dispatch the job to send emails
        SendContactEmails::dispatch($contactData);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your message. We will get back to you soon!'
        ]);
    }
}
