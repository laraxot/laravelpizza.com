<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Modulo',
        'plural' => 'Moduli',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Moduli',
        'icon' => 'heroicon-o-cube',
        'sort' => 65,
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Descrizione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_visible' => [
            'label' => 'Visibile',
            'help' => 'Se selezionato, la pagina sarà visibile nella navigazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Se selezionato, la pagina sarà attiva',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'is_home' => [
            'label' => 'Home',
            'help' => 'Se selezionato, la pagina sarà la home',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'priority' => [
            'label' => 'Priorità',
            'placeholder' => 'Priorità',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'colors' => [
            'label' => 'Colori',
            'placeholder' => 'Colori',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'key' => [
            'label' => 'color key',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => 'color',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'value',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'hex' => [
            'label' => 'hex',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Icona',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timezone' => [
            'label' => 'Fuso orario',
            'placeholder' => 'Fuso orario',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'path' => [
            'label' => 'path',
        ],
        'enabled' => [
            'label' => 'enabled',
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
    'label' => 'Module',
    'plural_label' => 'Module (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Module',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Module',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Module',
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
