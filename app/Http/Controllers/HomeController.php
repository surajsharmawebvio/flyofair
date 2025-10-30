<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\AirportRepository;
use App\Models\NewsLatter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Jobs\SendGetQuoteEmails;

class HomeController extends Controller
{
    protected $airportRepository;

    public function __construct(AirportRepository $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    public function index()
    {
        return Inertia::render('Home');
    }

    public function searchAirports(Request $request)
    {
        $input = $request->all();

        // get ip address from request

        // return [
        //     'ip' => $request->ip(),
        //     'input' => $input
        // ]
        
        $airports = $this->airportRepository->searchAirports($input);

        return response()->json($airports);
    }

    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:news_latters,email',
        ]);

        // Create a new newsletter subscription
        NewsLatter::create([
            'email' => $request->input('email'),
            'is_subscribed' => true,
        ]);

        return response()->json(['message' => 'Successfully subscribed to the newsletter.']);
    }

    public function siteMap()
    {
        return Inertia::render('SiteMap');
    }

    public function getQuote(Request $request)
    {
        // Basic validation
        $validator = Validator::make($request->all(), [
            'tripType' => 'required|in:oneway,round,multi',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        try {
            // dispatch a job to send emails (processed by queue workers)
            SendGetQuoteEmails::dispatch($data);

            return response()->json(['message' => 'Quote request queued for processing.']);
        } catch (Exception $e) {
            Log::error('Failed to dispatch quote email job: ' . $e->getMessage(), ['data' => $data]);
            return response()->json(['message' => 'Failed to queue quote request.'], 500);
        }
    }
}
