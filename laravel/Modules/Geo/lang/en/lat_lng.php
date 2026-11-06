<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Coordinate GPS',
        'group' => 'Gestione Territorio',
        'icon' => 'heroicon-o-map-pin',
        'sort' => '30',
    ],
    'fields' => [
        'latitude' => [
            'label' => 'Latitudine',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'select_position' => 'Seleziona Posizione',
        'update_coordinates' => 'Aggiorna Coordinate',
    ],
    'messages' => [
        'coordinates_updated' => 'Coordinate aggiornate con successo',
        'invalid_coordinates' => 'Coordinate non valide',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'widget' => [
        'locating' => [
            'label' => 'Getting your location...',
        ],
        'heading' => [
            'title' => 'Lat-lng',
        ],
        'latitude' => [
            'label' => 'lat',
        ],
        'longitude' => [
            'label' => 'lng',
        ],
        'error_code' => [
            'label' => 'Error code',
        ],
        'error_message' => [
            'label' => 'Error message',
        ],
    ],
];
