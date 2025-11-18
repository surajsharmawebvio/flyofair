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

    public function indexEs()
    {
        return Inertia::render('Home-es');
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
        // Fetch all published blog posts
        $blogs = \App\Models\Blog::select('title', 'slug', 'lang')
            ->where('published', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        // Split blogs by language and convert to arrays
        $englishBlogs = $blogs->where('lang', 'en')->values()->toArray();
        $spanishBlogs = $blogs->where('lang', 'es')->values()->toArray();

        return Inertia::render('SiteMap', [
            'blogs' => $englishBlogs,
            'articulos' => $spanishBlogs
        ]);
    }

    public function generateSitemapXml()
    {
        // Fetch all published blog posts
        $blogs = \App\Models\Blog::select('slug', 'lang', 'updated_at')
            ->where('published', 1)
            ->get();

        // Create XML document with proper formatting
        $xml = new \DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        // Create root element with namespaces
        $urlset = $xml->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
        $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $urlset->setAttribute('xmlns:xhtml', 'http://www.w3.org/1999/xhtml');
        $urlset->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
        $xml->appendChild($urlset);

        // Add homepage
        $this->addUrlToSitemap($xml, $urlset, '/', '1.0', 'daily', now());

        // Add main English pages
        $englishPages = [
            '/about-us/' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/contact-us/' => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/blog/' => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/author/' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/terms-and-conditions/' => ['priority' => '0.6', 'changefreq' => 'yearly'],
            '/privacy-policy/' => ['priority' => '0.6', 'changefreq' => 'yearly'],
            '/disclaimer/' => ['priority' => '0.6', 'changefreq' => 'yearly'],
            '/sitemap/' => ['priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        foreach ($englishPages as $url => $settings) {
            $this->addUrlToSitemap($xml, $urlset, $url, $settings['priority'], $settings['changefreq'], now());
        }

        // Add Spanish homepage and main pages
        $spanishPages = [
            '/es/' => ['priority' => '0.8', 'changefreq' => 'daily'],
            '/es/sobre-nosotros/' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/es/contactanos/' => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/es/articulos/' => ['priority' => '0.8', 'changefreq' => 'daily'],
            '/es/autor/' => ['priority' => '0.6', 'changefreq' => 'monthly'],
            '/es/terminos-y-condiciones/' => ['priority' => '0.5', 'changefreq' => 'yearly'],
            '/es/politica-de-privacidad/' => ['priority' => '0.5', 'changefreq' => 'yearly'],
            '/es/descargo-de-responsabilidad/' => ['priority' => '0.5', 'changefreq' => 'yearly'],
        ];

        foreach ($spanishPages as $url => $settings) {
            $this->addUrlToSitemap($xml, $urlset, $url, $settings['priority'], $settings['changefreq'], now());
        }

        // Add blog posts and articles with language alternates
        foreach ($blogs as $blog) {
            $urlElement = $xml->createElement('url');
            $urlset->appendChild($urlElement);

            // Determine URL based on language
            $path = $blog->lang === 'en' ? 'blog' : 'articulos';
            $url = "/{$path}/{$blog->slug}/";

            // Add main URL
            $fullUrl = url($url);
            if (!str_ends_with($fullUrl, '/')) {
                $fullUrl .= '/';
            }
            $loc = $xml->createElement('loc', $fullUrl);
            $urlElement->appendChild($loc);

            // Add lastmod
            $lastmod = $xml->createElement('lastmod', $blog->updated_at->toW3cString());
            $urlElement->appendChild($lastmod);

            // Add changefreq
            $changefreq = $xml->createElement('changefreq', 'weekly');
            $urlElement->appendChild($changefreq);

            // Add priority
            $priority = $xml->createElement('priority', '0.8');
            $urlElement->appendChild($priority);

            // Add language alternates if there are blogs in both languages
            $alternateBlogs = $blogs->where('slug', $blog->slug)->where('lang', '!=', $blog->lang);
            if ($alternateBlogs->count() > 0) {
                foreach ($alternateBlogs as $altBlog) {
                    $altPath = $altBlog->lang === 'en' ? 'blog' : 'articulos';
                    $altUrl = "/{$altPath}/{$altBlog->slug}/";

                    $link = $xml->createElement('xhtml:link');
                    $link->setAttribute('rel', 'alternate');
                    $link->setAttribute('hreflang', $altBlog->lang);
                    $altFullUrl = url($altUrl);
                    if (!str_ends_with($altFullUrl, '/')) {
                        $altFullUrl .= '/';
                    }
                    $link->setAttribute('href', $altFullUrl);
                    $urlElement->appendChild($link);
                }
            }
        }

        // Create response
        $response = response($xml->saveXML(), 200);
        $response->header('Content-Type', 'text/xml; charset=UTF-8');

        // dd($response);

        // Save to root directory
        $xml->save(base_path('sitemap.xml'));

        return $response;
    }

    private function addUrlToSitemap($xml, $urlset, $url, $priority, $changefreq, $lastmod)
    {
        $urlElement = $xml->createElement('url');
        $urlset->appendChild($urlElement);

        // Generate URL and add trailing slash if not root
        $fullUrl = url($url);
        if ($url !== '/' && !str_ends_with($fullUrl, '/')) {
            $fullUrl .= '/';
        }

        $loc = $xml->createElement('loc', $fullUrl);
        $urlElement->appendChild($loc);

        $lastmodElement = $xml->createElement('lastmod', $lastmod->toW3cString());
        $urlElement->appendChild($lastmodElement);

        $changefreqElement = $xml->createElement('changefreq', $changefreq);
        $urlElement->appendChild($changefreqElement);

        $priorityElement = $xml->createElement('priority', $priority);
        $urlElement->appendChild($priorityElement);

        return $urlElement;
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
