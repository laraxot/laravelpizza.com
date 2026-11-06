<?php

declare(strict_types=1);

return [
    'heading' => 'Accessi Recenti',
    'columns' => [
        'user' => 'Utente',
        'login_at' => 'Ora Accesso',
        'ip_address' => 'Indirizzo IP',
        'user_agent' => 'User Agent',
    ],
    'fields' => [
        'authenticatable' => [
            'name' => [
                'label' => 'authenticatable.name',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'label' => 'login_at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ip_address' => [
            'label' => 'ip_address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_agent' => [
            'label' => 'user_agent',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'label' => 'user',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'delete' => [
            'tooltip' => 'delete',
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'create' => [
            'tooltip' => 'create',
            'icon' => 'create',
            'label' => 'create',
        ],
    ],
    'navigation' => [
        'name' => 'Accessi Recenti',
        'plural' => 'Accessi Recenti',
        'group' => [
            'name' => 'Generale',
            'description' => 'Impostazioni Generali',
        ],
        'label' => 'Accessi Recenti',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Accessi Recenti',
    'plural_label' => 'Accessi Recenti (Plurale)',
];
