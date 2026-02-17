<?php

declare(strict_types=1);

return [
    'actions' => [
        'delete' => [
            'label' => 'delete',
        ],
    ],
    'label' => 'Edit Failed Import Row',
    'plural_label' => 'Edit Failed Import Row (Plurale)',
    'navigation' => [
        'name' => 'Edit Failed Import Row',
        'plural' => 'Edit Failed Import Row',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Edit Failed Import Row',
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
