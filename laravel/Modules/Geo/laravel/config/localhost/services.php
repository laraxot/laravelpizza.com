<?php

declare(strict_types=1);

return [
    'facebook' => [
        'client_id' => '1976219272701103',
        'client_secret' => '74bf40f5687e1d29e32ed3837f953518',
        'redirect' => 'https://www.food.local/login/facebook/callback',
    ],
    'twitter' => [
        'client_id' => 'IgHlGiZndC9mQVI0u6M6IFtrI',
        'client_secret' => 'kCJKUxW8IBUICEi80m2JURRj6f82uIrDA7IuCWLfkLlgOgO8t4',
        'redirect' => 'https://www.food.local/login/twitter/callback',
    ],
    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI'),
    ],
    'google' => [
        'url_location_api' => 'https://maps.googleapis.com/maps/api/geocode/json',
        'maps_key' => 'AIzaSyDH_mjxDeYAeHV_ocThsU_CIvyGEq-vLYc',
    ],
    'bing' => [
        'url_location_api' => 'http://dev.virtualearth.net/REST/v1/Locations',
        'maps_key' => 'AmPyO21FqVEG0gyZGxBnE_8GMb2mdFXeqEeOAh9qQnwlK7VNGKP9MThKJIV_EVby',
    ],
    'netfun' => [
        'token' => env('NETFUN_TOKEN'),
    ],
];
