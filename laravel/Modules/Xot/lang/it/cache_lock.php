<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'cache lock',
        'plural' => 'cache locks',
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
    'label' => 'Cache Lock',
    'plural_label' => 'Cache Lock (Plurale)',
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
            'label' => 'Crea Cache Lock',
        ],
        'edit' => [
            'label' => 'Modifica Cache Lock',
        ],
        'delete' => [
            'label' => 'Elimina Cache Lock',
        ],
    ],
];
