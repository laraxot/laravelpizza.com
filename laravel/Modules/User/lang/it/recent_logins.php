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
                'label' => 'Utente autenticato',
            ],
            'label' => 'Utente autenticato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
<<<<<<< .merge_file_jZfwAY
            'label' => 'login_at',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
=======
            'label' => 'Ora accesso',
        ],
        'ip_address' => [
>>>>>>> .merge_file_zmCyzQ
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Indirizzo IP',
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
<<<<<<< .merge_file_jZfwAY
            'label' => 'Utente',
=======
>>>>>>> .merge_file_zmCyzQ
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Utente',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
<<<<<<< .merge_file_jZfwAY
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
=======
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
>>>>>>> .merge_file_zmCyzQ
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
