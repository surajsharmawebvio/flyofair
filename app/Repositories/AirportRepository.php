<?php

namespace App\Repositories;
use App\AirportRepositoryInterface;
use Illuminate\Support\Facades\Http;

class AirportRepository implements AirportRepositoryInterface
{
    protected $baseUrl = "https://development.theinfinitytravel.com/api/v1/all/airport-list?input=";

    public function __construct($baseUrl = "https://development.theinfinitytravel.com/api/v1/all/airport-list")
    {
        $this->baseUrl = $baseUrl;
    }
    public function searchAirports($input): array
    {
        $baseUrl = $this->baseUrl;

        if (is_string($input['query'])) {

            $url = str_replace('input=', 'input=' . $input['query'], $baseUrl);

        } if (!is_string($input['query']) && is_string($input['lat']) && is_string($input['lng'])) {

            $url = str_replace('input=', 'lat=' . $input['lat'] . '&lng=' . $input['lng'], $baseUrl);

        } else {

            $url = $baseUrl;
        }

        return json_decode(file_get_contents($url), true);
        
    }
}
