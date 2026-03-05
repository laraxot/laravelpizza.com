<?php

declare(strict_types=1);

return [
    'actions' => [
        'list_log_activities' => [
            'label' => 'list_log_activities',
            'icon' => 'list_log_activities',
            'tooltip' => 'list_log_activities',
        ],
        'test' => [
            'label' => 'test',
            'icon' => 'test',
            'tooltip' => 'test',
        ],
    ],
    'label' => 'Log Activities Action Test',
    'plural_label' => 'Log Activities Action Test (Plurale)',
    'navigation' => [
        'name' => 'Log Activities Action Test',
        'plural' => 'Log Activities Action Test',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Log Activities Action Test',
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
