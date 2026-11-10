<?php

declare(strict_types=1);

// Colonne e azioni della tabella performers (Tables\PerformersTable).
return [
    'fields' => [
        'name' => [
            'label' => 'Name',
        ],
        'type' => [
            'label' => 'Role',
        ],
        'company' => [
            'label' => 'Company',
        ],
        'email' => [
            'label' => 'Email',
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
