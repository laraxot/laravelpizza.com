<?php

declare(strict_types=1);

return [
    'actions' => [
        'edit' => [
            'label' => 'edit',
        ],
    ],
    'navigation' => [
        'name' => 'View Team',
        'plural' => 'View Team',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'View Team',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'View Team',
    'plural_label' => 'View Team (Plurale)',
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
