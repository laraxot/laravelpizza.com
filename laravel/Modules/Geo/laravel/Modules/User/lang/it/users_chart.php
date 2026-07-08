<?php

declare(strict_types=1);

return [
    'actions' => [
        'test' => [
            'label' => 'test',
        ],
    ],
    'navigation' => [
        'name' => 'Users Chart',
        'plural' => 'Users Chart',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Users Chart',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Users Chart',
    'plural_label' => 'Users Chart (Plurale)',
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
];
