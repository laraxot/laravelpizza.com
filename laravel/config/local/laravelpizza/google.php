<?php

declare(strict_types=1);

// https://maps.googleapis.com/maps/api/geocode/json?address=
$default = [
    'url_location_api' => 'https://maps.googleapis.com/maps/api/geocode/json',
    'maps_key' => env('GOOGLE_MAPS_API_KEY'),
];

return $default;
