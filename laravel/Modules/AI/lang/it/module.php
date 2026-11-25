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
            'label' => 'Colore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'Valore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'hex' => [
            'label' => 'Hex',
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
            'label' => 'Percorso',
        ],
        'enabled' => [
            'label' => 'Attivo',
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
            'tooltip' => '',
        ],
        'edit' => [
            'label' => 'Modifica Module',
            'icon' => 'edit',
            'tooltip' => '',
        ],
        'delete' => [
            'label' => 'Elimina Module',
            'icon' => 'delete',
            'tooltip' => '',
        ],
        'createAnother' => [
            'label' => 'Salva e crea un altro',
            'icon' => 'createAnother',
            'tooltip' => '',
        ],
        'save' => [
            'label' => 'Salva',
            'icon' => 'save',
            'tooltip' => '',
        ],
        'view' => [
            'label' => 'Vista',
            'icon' => 'view',
            'tooltip' => '',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
        ],
    ],
];
