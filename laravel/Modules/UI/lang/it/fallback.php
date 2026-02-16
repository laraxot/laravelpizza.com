<?php

declare(strict_types=1);

return [
    'label' => 'Fallback',
    'plural_label' => 'Fallback (Plurale)',
    'navigation' => [
        'name' => 'Fallback',
        'plural' => 'Fallback',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Fallback',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
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
    'actions' => [
        'create' => [
            'label' => 'Crea Fallback',
        ],
        'edit' => [
            'label' => 'Modifica Fallback',
        ],
        'delete' => [
            'label' => 'Elimina Fallback',
        ],
    ],
];
