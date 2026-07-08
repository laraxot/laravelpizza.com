<?php

declare(strict_types=1);

return [
    'backend' => [
        'access' => [
            'title' => 'Gestione accessi',
            'roles' => [
                'all' => 'Tutti i ruoli',
                'create' => 'Crea ruolo',
                'edit' => 'Modifica ruolo',
                'management' => 'Gestione ruoli',
                'main' => 'Ruoli',
            ],
            'users' => [
                'all' => 'Tutti gli utenti',
                'change-password' => 'Cambia password',
                'create' => 'Crea utente',
                'deactivated' => 'Utenti disattivati',
                'deleted' => 'Utenti eliminati',
                'edit' => 'Modifica utente',
                'main' => 'Utenti',
                'view' => 'View User',
            ],
        ],
        'log-viewer' => [
            'main' => 'Log',
            'dashboard' => 'Dashboard',
            'logs' => 'Logs',
        ],
        'sidebar' => [
            'dashboard' => 'Dashboard',
            'general' => 'Generale',
            'system' => 'System',
        ],
    ],
    'language-picker' => [
        'language' => 'Lingua',
        'langs' => [
            'ar' => 'العربية (Arabic]',
            'da' => 'Danese (Danish]',
            'de' => 'Tedesco (German]',
            'el' => '(Greek]',
            'en' => 'Inglese (English]',
            'es' => 'Spagnol (Spanish]',
            'fr' => 'Francese (French]',
            'it' => 'Italiano (Italian]',
            'nl' => 'Olandese (Dutch]',
            'pt_BR' => 'Portoghese Brasiliano (Brazilian Portuguese]',
            'sv' => 'Svedese (Swedish]',
            'th' => 'Thai',
        ],
    ],
    'label' => 'Menus',
    'plural_label' => 'Menus (Plurale)',
    'navigation' => [
        'name' => 'Menus',
        'plural' => 'Menus',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Menus',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
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
            'label' => 'Crea Menus',
        ],
        'edit' => [
            'label' => 'Modifica Menus',
        ],
        'delete' => [
            'label' => 'Elimina Menus',
        ],
    ],
];
