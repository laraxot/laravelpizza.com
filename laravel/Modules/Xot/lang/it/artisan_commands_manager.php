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
            'label' => 'Riavvia code',
            'icon' => 'queue_restart',
            'tooltip' => 'Riavvia i processi delle code',
        ],
        'event_cache' => [
            'label' => 'Cache degli eventi',
            'icon' => 'event_cache',
            'tooltip' => 'Genera la cache degli eventi',
        ],
        'route_cache' => [
            'label' => 'Cache delle rotte',
            'icon' => 'route_cache',
            'tooltip' => 'Genera la cache delle rotte',
        ],
        'config_cache' => [
            'label' => 'Cache della configurazione',
            'icon' => 'config_cache',
            'tooltip' => 'Genera la cache della configurazione',
        ],
        'view_cache' => [
            'label' => 'Cache delle viste',
            'icon' => 'view_cache',
            'tooltip' => 'Genera la cache delle viste',
        ],
        'filament_optimize' => [
            'label' => 'Ottimizza Filament',
            'icon' => 'filament_optimize',
            'tooltip' => 'Ottimizza Filament',
        ],
        'filament_upgrade' => [
            'label' => 'Aggiorna Filament',
            'icon' => 'filament_upgrade',
            'tooltip' => 'Aggiorna Filament',
        ],
        'migrate' => [
            'label' => 'Esegui migrazioni',
            'icon' => 'migrate',
            'tooltip' => 'Esegue le migrazioni del database',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
        'composer_dump_autoload' => [
            'label' => 'composer_dump_autoload',
            'icon' => 'composer_dump_autoload',
            'tooltip' => 'composer_dump_autoload',
        ],
        'notify_migrate_themes_to_mail_templates' => [
            'label' => 'notify_migrate_themes_to_mail_templates',
            'icon' => 'notify_migrate_themes_to_mail_templates',
            'tooltip' => 'notify_migrate_themes_to_mail_templates',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
    ],
    'title' => 'Gestore comandi Artisan',
    'label' => 'Artisan Commands Manager',
    'plural_label' => 'Artisan Commands Manager (Plurale)',
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
];
