<?php

declare(strict_types=1);

return [
    'name' => 'name',
    'value' => 'value',
    'label' => 'Xot Base Job',
    'plural_label' => 'Xot Base Job (Plurale)',
    'navigation' => [
        'name' => 'Xot Base Job',
        'plural' => 'Xot Base Job',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Xot Base Job',
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
            'label' => 'Crea Xot Base Job',
        ],
        'edit' => [
            'label' => 'Modifica Xot Base Job',
        ],
        'delete' => [
            'label' => 'Elimina Xot Base Job',
        ],
    ],
];
