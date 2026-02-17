<?php

declare(strict_types=1);

return [
    'sections' => [
        'empty' => [
            'label' => 'empty',
            'heading' => 'empty',
        ],
    ],
    'label' => 'Events Stats',
    'plural_label' => 'Events Stats (Plurale)',
    'navigation' => [
        'name' => 'Events Stats',
        'plural' => 'Events Stats',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Events Stats',
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
            'label' => 'Crea Events Stats',
        ],
        'edit' => [
            'label' => 'Modifica Events Stats',
        ],
        'delete' => [
            'label' => 'Elimina Events Stats',
        ],
    ],
];
