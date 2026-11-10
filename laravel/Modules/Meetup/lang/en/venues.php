<?php

declare(strict_types=1);

// Colonne e azioni della tabella venues (Tables\VenuesTable).
return [
    'fields' => [
        'name' => [
            'label' => 'Name',
        ],
        'city' => [
            'label' => 'City',
        ],
        'address' => [
            'label' => 'Address',
        ],
        'capacity' => [
            'label' => 'Capacity',
        ],
        'events_count' => [
            'label' => 'Events',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New',
            'tooltip' => 'New',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete',
        ],
        'view' => [
            'label' => 'Open',
            'tooltip' => 'Open',
        ],
        'layout' => [
            'label' => 'Change view',
            'tooltip' => 'Change view (table or cards)',
        ],
    ],
];
