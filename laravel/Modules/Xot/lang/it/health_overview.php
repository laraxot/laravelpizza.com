<?php

declare(strict_types=1);

return [
    'sections' => [
        'empty' => [
            'label' => 'empty',
            'heading' => 'empty',
        ],
    ],
    'label' => 'Health Overview',
    'plural_label' => 'Health Overview (Plurale)',
    'navigation' => [
        'name' => 'Health Overview',
        'plural' => 'Health Overview',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Health Overview',
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
            'label' => 'Crea Health Overview',
        ],
        'edit' => [
            'label' => 'Modifica Health Overview',
        ],
        'delete' => [
            'label' => 'Elimina Health Overview',
        ],
    ],
];
