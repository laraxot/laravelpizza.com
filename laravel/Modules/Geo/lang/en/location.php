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
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Select a city',
            'help' => 'Select or enter the city name',
            'tooltip' => 'City name',
            'description' => 'City of the address',
            'icon' => 'heroicon-o-building-office',
            'color' => 'primary',
            'helper_text' => '',
        ],
        'province' => [
            'label' => 'Province',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'country' => [
            'label' => 'Country',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'latitude' => [
            'label' => 'Latitude',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'longitude' => [
            'label' => 'Longitude',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
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
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
