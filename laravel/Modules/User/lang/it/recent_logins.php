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
<<<<<<< HEAD
                'label' => 'Utente autenticato',
            ],
            'label' => 'Utente autenticato',
=======
                'label' => 'authenticatable.name',
            ],
            'label' => '',
>>>>>>> laraxot/dev
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
<<<<<<< HEAD
            'label' => 'Ora accesso',
        ],
        'ip_address' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Indirizzo IP',
=======
            'label' => 'login_at',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Utente',
=======
            'label' => 'Utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
>>>>>>> laraxot/dev
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
<<<<<<< HEAD
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
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'Apri filtri',
        ],
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
            'label' => 'Reimposta colonne',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'Elimina',
        ],
        'layout' => [
            'icon' => 'layout',
            'label' => 'Layout',
        ],
        'create' => [
            'icon' => 'create',
            'label' => 'Crea',
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
>>>>>>> laraxot/dev
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
