<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Cache',
        'plural' => 'Cache',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Cache',
        'icon' => 'heroicon-o-circle-stack',
        'sort' => 90,
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
    'label' => 'Cache',
    'plural_label' => 'Cache (Plurale)',
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
        'value' => [
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Cache',
            'icon' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Cache',
            'icon' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Cache',
            'icon' => 'delete',
        ],
        'createAnother' => [
            'icon' => 'createAnother',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'view' => [
            'icon' => 'view',
        ],
        'route:list' => [
            'icon' => 'route:list',
        ],
        'icons:cache' => [
            'icon' => 'icons:cache',
        ],
        'filament:cache-components' => [
            'icon' => 'filament:cache-components',
        ],
        'filament:clear-cached-components' => [
            'icon' => 'filament:clear-cached-components',
        ],
    ],
];
