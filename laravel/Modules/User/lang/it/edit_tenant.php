<?php

declare(strict_types=1);

return [
    'actions' => [
        'view' => [
            'label' => 'view',
        ],
        'delete' => [
            'label' => 'delete',
        ],
    ],
    'navigation' => [
        'name' => 'Edit Tenant',
        'plural' => 'Edit Tenant',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Tenant',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Edit Tenant',
    'plural_label' => 'Edit Tenant (Plurale)',
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
