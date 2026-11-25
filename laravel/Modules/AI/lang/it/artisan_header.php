<?php

declare(strict_types=1);

return [
    'label' => 'Artisan Header',
    'plural_label' => 'Artisan Header (Plurale)',
    'navigation' => [
        'name' => 'Artisan Header',
        'plural' => 'Artisan Header',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Artisan Header',
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
