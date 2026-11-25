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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
<<<<<<< .merge_file_PYk99O
            'label' => 'Ora accesso',
        ],
        'ip_address' => [
=======
            'label' => 'login_at',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
>>>>>>> .merge_file_ucAOoc
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_agent' => [
            'label' => 'Browser (user agent)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
<<<<<<< .merge_file_PYk99O
=======
            'label' => 'Utente',
>>>>>>> .merge_file_ucAOoc
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
<<<<<<< .merge_file_PYk99O
            'label' => 'Riordina',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'Gestisci colonne',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'Applica colonne',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'Reimposta filtri',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'label' => 'Applica filtri',
=======
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
>>>>>>> .merge_file_ucAOoc
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'layout' => [
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'create' => [
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
