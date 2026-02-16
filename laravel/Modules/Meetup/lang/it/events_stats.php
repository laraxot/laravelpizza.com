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
