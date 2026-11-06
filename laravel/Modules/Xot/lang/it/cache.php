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
        'key' => [
            'label' => 'key',
            'placeholder' => 'key',
            'helper_text' => 'key',
            'description' => 'key',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => '',
            'description' => 'value',
        ],
        'expiration' => [
            'label' => 'expiration',
            'placeholder' => 'expiration',
            'helper_text' => 'expiration',
            'description' => 'expiration',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Cache',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Cache',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Cache',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'route:list' => [
            'label' => 'route:list',
            'icon' => 'route:list',
            'tooltip' => 'route:list',
        ],
        'icons:cache' => [
            'label' => 'icons:cache',
            'icon' => 'icons:cache',
            'tooltip' => 'icons:cache',
        ],
        'filament:cache-components' => [
            'label' => 'filament:cache-components',
            'icon' => 'filament:cache-components',
            'tooltip' => 'filament:cache-components',
        ],
        'filament:clear-cached-components' => [
            'label' => 'filament:clear-cached-components',
            'icon' => 'filament:clear-cached-components',
            'tooltip' => 'filament:clear-cached-components',
        ],
    ],
];
