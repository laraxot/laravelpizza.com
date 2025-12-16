<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Comandi Artisan',
        'plural' => 'Comandi Artisan',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione dei comandi Artisan',
        ],
        'sort' => 28,
        'label' => 'Comandi Artisan',
        'icon' => 'heroicon-o-command-line',
    ],
    'pages' => [
        'artisan-commands' => [
            'title' => 'Gestione Comandi Artisan',
            'description' => 'Esegui e gestisci i comandi Artisan',
            'commands' => [
                'migrate' => [
                    'label' => 'Migrazione Database',
                    'description' => 'Esegue le migrazioni del database',
                ],
                'optimize' => [
                    'label' => 'Ottimizzazione',
                    'description' => 'Ottimizza le prestazioni dell\'applicazione',
                ],
                'cache' => [
                    'label' => 'Gestione Cache',
                    'description' => 'Comandi per la gestione della cache',
                ],
            ],
            'notifications' => [
                'success' => 'Comando eseguito con successo',
                'error' => 'Errore nell\'esecuzione del comando',
            ],
        ],
    ],
    'actions' => [
        'queue_restart' => [
            'label' => 'queue_restart',
        ],
        'event_cache' => [
            'label' => 'event_cache',
        ],
        'route_cache' => [
            'label' => 'route_cache',
        ],
        'config_cache' => [
            'label' => 'config_cache',
        ],
        'view_cache' => [
            'label' => 'view_cache',
        ],
        'filament_optimize' => [
            'label' => 'filament_optimize',
        ],
        'filament_upgrade' => [
            'label' => 'filament_upgrade',
        ],
        'migrate' => [
            'label' => 'migrate',
        ],
    ],
    'title' => 'artisan commands manager',
];
