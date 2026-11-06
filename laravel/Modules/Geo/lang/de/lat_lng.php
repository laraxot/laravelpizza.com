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
            'label' => 'Standort wird ermittelt...',
        ],
        'heading' => [
            'title' => 'Breiten-/Längengrad',
        ],
        'latitude' => [
            'label' => 'Breite',
        ],
        'longitude' => [
            'label' => 'Länge',
        ],
        'error_code' => [
            'label' => 'Fehlercode',
        ],
        'error_message' => [
            'label' => 'Fehlermeldung',
        ],
    ],
];
