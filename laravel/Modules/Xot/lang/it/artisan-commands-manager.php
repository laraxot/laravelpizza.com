<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-command-line',
        'group' => 'Sistema',
        'label' => 'Comandi Artisan',
        'sort' => 10,
    ],
    'commands' => [
        'migrate' => [
            'label' => 'Migrazione Database',
        ],
        'filament_upgrade' => [
            'label' => 'Aggiorna Filament',
        ],
        'filament_optimize' => [
            'label' => 'Ottimizza Filament',
        ],
        'view_cache' => [
            'label' => 'Cache delle View',
        ],
        'config_cache' => [
            'label' => 'Cache della Configurazione',
        ],
        'route_cache' => [
            'label' => 'Cache delle Route',
        ],
        'event_cache' => [
            'label' => 'Cache degli Eventi',
        ],
        'queue_restart' => [
            'label' => 'Riavvia Code',
        ],
        'composer_dump_autoload' => [
            'label' => 'Composer Dump Autoload',
        ],
        'notify_migrate_themes_to_mail_templates' => [
            'label' => 'Importa Vecchi Template Email/SMS',
            'modal_description' => 'Copia i contenuti email/SMS dalla vecchia tabella notify_themes verso mail_templates (il nuovo sistema di invio inviti). Operazione idempotente: rilanciarla aggiorna i template già migrati invece di duplicarli, sovrascrivendo eventuali modifiche fatte a mano dopo l\'ultima esecuzione.',
        ],
    ],
    'status' => [
        'completed' => 'Completato',
        'failed' => 'Fallito',
        'waiting' => 'In attesa dell\'output...',
        'running' => 'In esecuzione...',
    ],
    'messages' => [
        'command_started' => 'Comando Avviato',
        'command_started_desc' => 'Il comando :command è stato avviato. L\'output apparirà in tempo reale.',
        'command_completed' => 'Comando Completato',
        'command_completed_desc' => 'Il comando :command è stato completato con successo',
        'command_failed' => 'Comando Fallito',
        'command_failed_desc' => 'Il comando :command è fallito. Controlla l\'output per i dettagli.',
        'running_command' => [
            'message' => 'Comando in esecuzione: :command',
        ],
    ],
    'hints' => [
        'running' => 'Il comando è in esecuzione. L\'output apparirà in tempo reale.',
        'disabled' => 'Non è possibile eseguire altri comandi mentre un comando è in esecuzione.',
        'scroll' => 'L\'output si aggiorna automaticamente e scorre verso il basso.',
    ],
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
    'actions' => [
        'create' => [
            'label' => 'Crea Artisan Commands Manager',
        ],
        'edit' => [
            'label' => 'Modifica Artisan Commands Manager',
        ],
        'delete' => [
            'label' => 'Elimina Artisan Commands Manager',
        ],
    ],
    'select_command' => 'Seleziona un comando dall\'intestazione per iniziare.',
];
