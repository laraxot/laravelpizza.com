<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Coordinate GPS',
        'group' => 'Gestione Territorio',
        'icon' => 'heroicon-o-map-pin',
        'sort' => 30,
    ],
    'fields' => [
        'latitude' => 'Latitudine',
        'longitude' => 'Longitudine',
    ],
    'actions' => [
        'select_position' => 'Seleziona Posizione',
        'update_coordinates' => 'Aggiorna Coordinate',
    ],
    'messages' => [
        'coordinates_updated' => 'Coordinate aggiornate con successo',
        'invalid_coordinates' => 'Coordinate non valide',
    ],
];
