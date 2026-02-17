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
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'city' => [
            'label' => 'Città',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'province' => [
            'label' => 'Provincia',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'country' => [
            'label' => 'Paese',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
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
        'type' => [
            'label' => 'Tipo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
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
    'label' => 'Location',
    'plural_label' => 'Location (Plurale)',
];
