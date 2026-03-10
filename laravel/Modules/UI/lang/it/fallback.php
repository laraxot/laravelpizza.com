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
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
