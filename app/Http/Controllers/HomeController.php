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
use App\Models\Quote;

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
            // when tripType is multi expect trips array with from/to/date
            'trips' => 'required_if:tripType,multi|array',
            'trips.*.from' => 'required_with:trips|string',
            'trips.*.to' => 'required_with:trips|string',
            'trips.*.date' => 'required_with:trips|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // dd($data);

        try {

            // Create a new quote
            $quote = new Quote();
            $quote->trip_type = $data['tripType'];
            $quote->email = $data['email'];
            $quote->phone = $data['phone'] ?? null;
            $quote->traveler_info = $data['travelerInfo'] ?? '';

            // Handle per-trip-type fields
            if (($data['tripType'] ?? '') === 'multi') {
                // Expecting an array of trips in 'trips' (from front-end)
                $trips = $data['trips'] ?? [];
                // Store the multi-city details as JSON
                $quote->multi_city_details = !empty($trips) ? json_encode($trips) : null;

                // Set from/to to first trip values if available (fallback empty)
                if (!empty($trips) && is_array($trips[0])) {
                    $quote->from_location = $trips[0]['from'] ?? '';
                    $quote->to_location = $trips[0]['to'] ?? '';
                    // Use first trip date as primary departure_date to satisfy non-null constraint
                    $quote->departure_date = $trips[0]['date'] ?? null;
                } else {
                    $quote->from_location = '';
                    $quote->to_location = '';
                    $quote->departure_date = null;
                }

                $quote->return_date = null;
            } else {
                $quote->from_location = $data['from'] ?? '';
                $quote->to_location = $data['to'] ?? '';
                $quote->departure_date = $data['departureDate'] ?? null;
                $quote->return_date = $data['returnDate'] ?? null;
                $quote->multi_city_details = isset($data['multiCityDetails']) ? json_encode($data['multiCityDetails']) : null;
            }

            $quote->status = 'pending';
            $quote->save();

            // dispatch a job to send emails (processed by queue workers)
            SendGetQuoteEmails::dispatch($data);

            return response()->json(['message' => 'Quote request queued for processing.']);
        } catch (Exception $e) {
            Log::error('Failed to dispatch quote email job: ' . $e->getMessage(), ['data' => $data]);
            return response()->json(['message' => 'Failed to queue quote request.'], 500);
        }
    }
}
