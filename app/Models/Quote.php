<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'trip_type',
        'email',
        'phone',
        'traveler_info',
        'from_location',
        'to_location',
        'departure_date',
        'return_date',
        'multi_city_details',
        'status',
    ];

    protected $casts = [
        'multi_city_details' => 'array',
        'departure_date' => 'date',
        'return_date' => 'date',
    ];
}
