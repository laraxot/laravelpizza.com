<?php

declare(strict_types=1);

return [
    'actions' => [
        'delete' => [
            'label' => 'delete',
        ],
    ],
    'navigation' => [
        'name' => 'Base Edit User',
        'plural' => 'Base Edit User',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Base Edit User',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Base Edit User',
    'plural_label' => 'Base Edit User (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
];
