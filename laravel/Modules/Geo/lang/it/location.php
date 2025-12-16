<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Località',
        'plural' => 'Località',
        'group' => [
            'name' => 'Geo',
            'description' => 'Gestione delle località e posizioni geografiche',
        ],
        'label' => 'Località',
        'sort' => 94,
        'icon' => 'ui-geo-location',
    ],
    'fields' => [
        'name' => 'Nome',
        'address' => 'Indirizzo',
        'city' => 'Città',
        'province' => 'Provincia',
        'postal_code' => 'CAP',
        'country' => 'Paese',
        'latitude' => 'Latitudine',
        'longitude' => 'Longitudine',
        'type' => 'Tipo',
        'status' => 'Stato',
    ],
    'types' => [
        'business' => 'Attività',
        'residence' => 'Residenza',
        'point_of_interest' => 'Punto di Interesse',
        'landmark' => 'Punto di Riferimento',
    ],
    'actions' => [
        'view_map' => 'Visualizza Mappa',
        'get_directions' => 'Ottieni Indicazioni',
        'copy_coordinates' => 'Copia Coordinate',
    ],
];
