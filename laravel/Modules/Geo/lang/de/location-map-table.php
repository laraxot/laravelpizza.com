<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Tabella Posizioni',
        'group' => 'Gestione Territorio',
        'icon' => 'ui-geo-location',
        'sort' => '15',
    ],
    'table' => [
        'columns' => [
            'name' => 'Nome',
            'address' => 'Indirizzo',
            'coordinates' => 'Coordinate',
            'actions' => 'Azioni',
        ],
        'filters' => [
            'with_coordinates' => 'Con coordinate',
            'without_coordinates' => 'Senza coordinate',
        ],
    ],
    'actions' => [
        'view_on_map' => 'Visualizza sulla mappa',
        'edit_coordinates' => 'Modifica coordinate',
        'export' => 'Esporta dati',
    ],
];
