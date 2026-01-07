<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Modulo',
        'plural' => 'Moduli',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'name' => ['label' => 'Nome', 'placeholder' => 'Nome'],
        'description' => ['label' => 'Descrizione', 'placeholder' => 'Descrizione'],
        'is_visible' => ['label' => 'Visibile', 'help' => 'Se selezionato, la pagina sarà visibile nella navigazione'],
        'is_active' => ['label' => 'Attivo', 'help' => 'Se selezionato, la pagina sarà attiva'],
        'is_home' => ['label' => 'Home', 'help' => 'Se selezionato, la pagina sarà la home'],
        'status' => ['label' => 'Stato', 'placeholder' => 'Stato'],
        'priority' => ['label' => 'Priorità', 'placeholder' => 'Priorità'],
        'colors' => ['label' => 'Colori', 'placeholder' => 'Colori'],
        'key' => ['label' => 'color key'],
        'color' => ['label' => 'color'],
        'value' => ['label' => 'value'],
        'hex' => ['label' => 'hex'],
        'icon' => ['label' => 'Icona', 'placeholder' => 'Icona'],
        'timezone' => ['label' => 'Fuso orario', 'placeholder' => 'Fuso orario'],
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
];
