<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Tabella Posizioni',
        'group' => 'Territory Management',
        'icon' => 'ui-geo-location',
        'sort' => '15',
    ],
    'table' => [
        'columns' => [
            'name' => 'Name',
            'address' => 'Address',
            'coordinates' => 'Coordinate',
            'actions' => 'Actions',
        ],
        'filters' => [
            'with_coordinates' => 'With coordinates',
            'without_coordinates' => 'Senza coordinate',
        ],
    ],
    'actions' => [
        'view_on_map' => 'View on map',
        'edit_coordinates' => 'Edit coordinates',
        'export' => 'Export data',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
