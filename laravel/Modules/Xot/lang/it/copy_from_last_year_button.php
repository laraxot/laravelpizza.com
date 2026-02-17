<?php

declare(strict_types=1);

return [
    'actions' => [
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
        ],
    ],
    'label' => 'Copy From Last Year Button',
    'plural_label' => 'Copy From Last Year Button (Plurale)',
    'navigation' => [
        'name' => 'Copy From Last Year Button',
        'plural' => 'Copy From Last Year Button',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Copy From Last Year Button',
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
];
