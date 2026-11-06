<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'sessione',
        'plural' => 'sessioni',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Sessione',
        'icon' => 'heroicon-o-user',
        'sort' => 21,
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
    'label' => 'Session',
    'plural_label' => 'Session (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
            'placeholder' => 'id',
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
        'user_id' => [
            'label' => 'user_id',
            'placeholder' => 'user_id',
            'helper_text' => 'user_id',
            'description' => 'user_id',
        ],
        'ip_address' => [
            'label' => 'ip_address',
            'placeholder' => 'ip_address',
            'helper_text' => 'ip_address',
            'description' => 'ip_address',
        ],
        'user_agent' => [
            'label' => 'user_agent',
            'placeholder' => 'user_agent',
            'helper_text' => 'user_agent',
            'description' => 'user_agent',
        ],
        'payload' => [
            'label' => 'payload',
            'placeholder' => 'payload',
            'helper_text' => 'payload',
            'description' => 'payload',
        ],
        'last_activity' => [
            'label' => 'last_activity',
            'placeholder' => 'last_activity',
            'helper_text' => 'last_activity',
            'description' => 'last_activity',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Session',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Session',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Session',
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
