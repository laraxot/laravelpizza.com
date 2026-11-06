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
    ],
    'status' => [
        'completed' => 'Abgeschlossen',
        'failed' => 'Fehlgeschlagen',
        'waiting' => 'Warten auf Ausgabe...',
        'running' => 'Wird ausgeführt...',
    ],
    'messages' => [
        'command_started' => 'Comando Avviato',
        'command_started_desc' => 'Il comando :command è stato avviato. L\'output apparirà in tempo reale.',
        'command_completed' => 'Comando Completato',
        'command_completed_desc' => 'Il comando :command è stato completato con successo',
        'command_failed' => 'Comando Fallito',
        'command_failed_desc' => 'Il comando :command è fallito. Controlla l\'output per i dettagli.',
        'running_command' => [
            'message' => 'Laufender Befehl: :command',
        ],
    ],
    'hints' => [
        'running' => 'Der Befehl wird ausgeführt. Die Ausgabe erscheint in Echtzeit.',
        'disabled' => 'Solange ein Befehl ausgeführt wird, können keine weiteren Befehle gestartet werden.',
        'scroll' => 'Die Ausgabe wird automatisch aktualisiert und scrollt nach unten.',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'fields' => [
    ],
    'actions' => [
    ],
    'select_command' => 'Wählen Sie im Header einen Befehl aus, um zu beginnen.',
];
