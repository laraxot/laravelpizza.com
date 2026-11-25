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
            'label' => 'Update Filament',
        ],
        'filament_optimize' => [
            'label' => 'Ottimizza Filament',
        ],
        'view_cache' => [
            'label' => 'View cache',
        ],
        'config_cache' => [
            'label' => 'Config cache',
        ],
        'route_cache' => [
            'label' => 'Route cache',
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
        'command_started' => 'Command started',
        'command_started_desc' => 'The :command command has started. Output will appear in real time.',
        'command_completed' => 'Command completed',
        'command_completed_desc' => 'The :command command completed successfully',
        'command_failed' => 'Command failed',
        'command_failed_desc' => 'The :command command failed. Check the output for details.',
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
    'select_command' => 'Select a command from the header to begin.',
];
