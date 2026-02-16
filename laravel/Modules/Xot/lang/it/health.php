<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Salute',
        'plural' => 'Salute',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'pages' => [
        'health_check_results' => [
            'buttons' => [
                'refresh' => 'Refresh',
            ],
            'heading' => 'Application Health',
            'navigation' => [
                'group' => 'Settings',
                'label' => 'Application Health',
            ],
            'notifications' => [
                'check_results' => 'Check results from',
            ],
        ],
    ],
    'actions' => [
        'refresh' => [
            'label' => 'refresh',
            'tooltip' => 'refresh',
            'icon' => 'refresh',
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'label' => 'Health',
    'plural_label' => 'Health (Plurale)',
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
];
