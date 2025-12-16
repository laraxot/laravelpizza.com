<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Log',
        'plural' => 'Log',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione dei log di sistema',
        ],
        'label' => 'Log',
        'sort' => '61',
        'icon' => 'activity-log-animated',
    ],
    'fields' => [
        'level' => [
            'label' => 'Livello',
            'emergency' => 'Emergency',
            'alert' => 'Alert',
            'critical' => 'Critical',
            'error' => 'Error',
            'warning' => 'Warning',
            'notice' => 'Notice',
            'info' => 'Info',
            'debug' => 'Debug',
        ],
        'message' => 'Messaggio',
        'context' => [
            'label' => 'Contesto',
            'exception' => 'Eccezione',
            'stack_trace' => 'Stack Trace',
            'additional' => 'Info Aggiuntive',
        ],
        'channel' => [
            'label' => 'Canale',
            'system' => 'Sistema',
            'application' => 'Applicazione',
            'security' => 'Sicurezza',
            'database' => 'Database',
            'queue' => 'Code',
        ],
        'datetime' => 'Data e Ora',
        'environment' => 'Ambiente',
    ],
    'filters' => [
        'level' => 'Livello',
        'channel' => 'Canale',
        'date_range' => 'Intervallo Date',
        'environment' => 'Ambiente',
        'search' => 'Cerca nel messaggio',
    ],
    'actions' => [
        'view_details' => 'Visualizza Dettagli',
        'download' => 'Scarica',
        'clear' => 'Pulisci',
        'archive' => 'Archivia',
    ],
    'messages' => [
        'no_logs' => 'Nessun log trovato',
        'cleared' => 'Log eliminati con successo',
        'archived' => 'Log archiviati con successo',
        'downloaded' => 'File log scaricato con successo',
    ],
    'badges' => [
        'level' => [
            'emergency' => 'Emergenza',
            'alert' => 'Allerta',
            'critical' => 'Critico',
            'error' => 'Errore',
            'warning' => 'Attenzione',
            'notice' => 'Avviso',
            'info' => 'Info',
            'debug' => 'Debug',
        ],
    ],
];
