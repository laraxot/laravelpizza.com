<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Geo Settings',
        'plural' => 'Geo Settings',
        'group' => [
            'name' => 'Geo',
            'description' => 'Geographic module configuration',
        ],
        'label' => 'Settings',
        'sort' => '34',
        'icon' => 'ui-settings',
    ],
    'fields' => [
        'default_map_provider' => [
            'label' => 'Provider Mappa Predefinito',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'api_keys' => [
            'google_maps' => 'API Key Google Maps',
            'mapbox' => 'API Key Mapbox',
            'here' => 'API Key HERE Maps',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'default_location' => [
            'lat' => 'Latitudine Predefinita',
            'lng' => 'Longitudine Predefinita',
            'zoom' => 'Zoom Predefinito',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'display_options' => [
            'units' => 'Measurement Units',
            'language' => 'Map Language',
            'theme' => 'Tema Mappe',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'providers' => [
        'google' => 'Google Maps',
        'mapbox' => 'Mapbox',
        'here' => 'HERE Maps',
        'osm' => 'OpenStreetMap',
    ],
    'units' => [
        'metric' => 'Metrico',
        'imperial' => 'Imperiale',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
