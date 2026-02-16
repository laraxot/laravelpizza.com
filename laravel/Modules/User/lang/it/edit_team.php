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
        'name' => 'Edit Team',
        'plural' => 'Edit Team',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Team',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Edit Team',
    'plural_label' => 'Edit Team (Plurale)',
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
