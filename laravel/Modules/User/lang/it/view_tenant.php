<?php

declare(strict_types=1);

return [
    'actions' => [
        'edit' => [
            'label' => 'edit',
        ],
    ],
    'navigation' => [
        'name' => 'View Tenant',
        'plural' => 'View Tenant',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'View Tenant',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'View Tenant',
    'plural_label' => 'View Tenant (Plurale)',
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
