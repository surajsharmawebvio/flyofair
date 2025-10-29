<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Repositories\AirportRepository;
use App\Models\NewsLatter;

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
}
