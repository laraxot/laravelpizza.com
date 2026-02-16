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
    ],
    'hints' => [
        'running' => 'Il comando è in esecuzione. L\'output apparirà in tempo reale.',
        'disabled' => 'Non è possibile eseguire altri comandi mentre un comando è in esecuzione.',
        'scroll' => 'L\'output si aggiorna automaticamente e scorre verso il basso.',
    ],
];
