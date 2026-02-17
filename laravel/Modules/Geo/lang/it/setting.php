<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Impostazioni Geo',
        'plural' => 'Impostazioni Geo',
        'group' => [
            'name' => 'Geo',
            'description' => 'Configurazione del modulo geografico',
        ],
        'label' => 'Impostazioni',
        'sort' => 34,
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
            'units' => 'Unità di Misura',
            'language' => 'Lingua Mappe',
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
    'label' => 'Setting',
    'plural_label' => 'Setting (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Setting',
        ],
        'edit' => [
            'label' => 'Modifica Setting',
        ],
        'delete' => [
            'label' => 'Elimina Setting',
        ],
    ],
];
