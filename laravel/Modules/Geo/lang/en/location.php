<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Locations',
        'plural' => 'Locations',
        'group' => [
            'name' => 'Geo',
            'description' => 'Manage locations and geographic positions',
        ],
        'label' => 'Locations',
        'sort' => '94',
        'icon' => 'ui-geo-location',
    ],
    'fields' => [
        'name' => 'Name',
        'address' => 'Address',
        'city' => [
            'label' => 'City',
            'placeholder' => 'Select a city',
            'help' => 'Select or enter the city name',
            'tooltip' => 'City name',
            'description' => 'City of the address',
            'icon' => 'heroicon-o-building-office',
            'color' => 'primary',
        ],
        'province' => 'Province',
        'postal_code' => 'Postal Code',
        'country' => 'Country',
        'latitude' => 'Latitude',
        'longitude' => 'Longitude',
        'type' => 'Type',
        'status' => 'Status',
    ],
    'types' => [
        'business' => 'Business',
        'residence' => 'Residence',
        'point_of_interest' => 'Point of Interest',
        'landmark' => 'Landmark',
    ],
    'actions' => [
        'view_map' => 'View Map',
        'get_directions' => 'Get Directions',
        'copy_coordinates' => 'Copy Coordinates',
    ],
];
