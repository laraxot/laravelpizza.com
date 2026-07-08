<?php

declare(strict_types=1);

return [
    'actions' => [
        'activeLocale' => [
            'label' => 'activeLocale',
        ],
    ],
    'label' => 'Lang Base Edit Record',
    'plural_label' => 'Lang Base Edit Record (Plurale)',
    'navigation' => [
        'name' => 'Lang Base Edit Record',
        'plural' => 'Lang Base Edit Record',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Lang Base Edit Record',
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
