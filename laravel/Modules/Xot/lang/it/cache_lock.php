<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Blocco cache',
        'plural' => 'cache locks',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Lock Cache',
        'icon' => 'heroicon-o-shield-exclamation',
        'sort' => 95,
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
        'key' => [
            'label' => 'key',
            'placeholder' => 'key',
            'helper_text' => 'key',
            'description' => 'key',
        ],
        'owner' => [
            'label' => 'owner',
            'placeholder' => 'owner',
            'helper_text' => 'owner',
            'description' => 'owner',
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
            'label' => 'Crea Cache Lock',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Cache Lock',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Cache Lock',
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
    ],
];
