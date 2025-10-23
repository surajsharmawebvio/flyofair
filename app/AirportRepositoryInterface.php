<?php

namespace App;

interface AirportRepositoryInterface
{
    public function searchAirports(string $input): array;
}
