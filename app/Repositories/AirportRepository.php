<?php

namespace App\Repositories;
use App\AirportRepositoryInterface;

class AirportRepository implements AirportRepositoryInterface
{
    protected $searchBylatLong = "https://development.theinfinitytravel.com/api/v1/all/airport-list?lat=&lng=";
    protected $searchByName = "https://development.theinfinitytravel.com/api/v1/all/airport-list?input=";
    protected $populerAirport = "https://development.theinfinitytravel.com/api/v1/all/airport-list?input=";

    public function __construct($searchBylatLong = null, $searchByName = null, $populerAirport = null)
    {
        $this->searchBylatLong = $searchBylatLong ?? $this->searchBylatLong;
        $this->searchByName = $searchByName ?? $this->searchByName;
        $this->populerAirport = $populerAirport ?? $this->populerAirport;
    }
    public function searchBylatLong(float $lat, float $lng): array
    {
        $url = str_replace(['lat=', 'lng='], ['lat=' . $lat, 'lng=' . $lng], $this->searchBylatLong);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
    public function searchByName(string $input): array
    {
        $url = str_replace('input=', 'input=' . $input, $this->searchByName);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
    public function populerAirport(string $input): array
    {
        $url = str_replace('input=', 'input=' . $input, $this->populerAirport);
        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
