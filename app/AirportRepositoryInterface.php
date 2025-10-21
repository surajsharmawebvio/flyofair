<?php

namespace App;

interface AirportRepositoryInterface
{
    //searchBylatLong
    public function searchBylatLong(float $lat, float $lng): array;
    // searchByName
    public function searchByName(string $input): array;
    // populerAirport
    public function populerAirport(string $input): array;
}
