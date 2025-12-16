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
        ],
    ],
];
