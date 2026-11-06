<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-command-line',
        'group' => 'Sistema',
        'label' => 'Comandi Artisan',
        'sort' => '10',
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
            'label' => 'Import Legacy Email/SMS Templates',
            'modal_description' => 'Copies email/SMS content from the legacy notify_themes table into mail_templates (the new invite sending system). Idempotent: re-running it updates already-migrated templates instead of duplicating them, overwriting any manual edits made after the last run.',
        ],
    ],
    'status' => [
        'completed' => 'Completed',
        'failed' => 'Failed',
        'waiting' => 'Waiting for output...',
        'running' => 'Running...',
    ],
    'messages' => [
        'command_started' => 'Comando Avviato',
        'command_started_desc' => 'Il comando :command è stato avviato. L\'output apparirà in tempo reale.',
        'command_completed' => 'Comando Completato',
        'command_completed_desc' => 'Il comando :command è stato completato con successo',
        'command_failed' => 'Comando Fallito',
        'command_failed_desc' => 'Il comando :command è fallito. Controlla l\'output per i dettagli.',
        'running_command' => [
            'message' => 'Running command: :command',
        ],
    ],
    'hints' => [
        'running' => 'The command is running. The output will appear in real time.',
        'disabled' => 'Other commands cannot be run while a command is running.',
        'scroll' => 'The output updates automatically and scrolls down.',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
    'select_command' => 'Select a command from the header to begin.',
];
