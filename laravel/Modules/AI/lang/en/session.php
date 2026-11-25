<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Sessioni',
        'plural' => 'Sessioni',
        'group' => [
            'name' => 'Sistema',
            'description' => 'User session and security management',
        ],
        'label' => 'Session',
        'sort' => '18',
        'icon' => 'xot-session',
    ],
    'fields' => [
        'identification' => [
            'id' => [
                'label' => 'ID Sessione',
                'help' => 'Unique session identifier',
            ],
            'user_id' => [
                'label' => 'User',
                'placeholder' => 'Select the user',
                'help' => 'User who owns the session',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'ip_address' => [
                'label' => 'Indirizzo IP',
                'help' => 'Source IP of the connection',
            ],
            'user_agent' => [
                'label' => 'User Agent',
                'help' => 'Browser e sistema operativo utilizzati',
            ],
            'location' => [
                'label' => 'Posizione',
                'help' => 'Localizzazione geografica approssimativa',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'payload' => [
                'label' => 'Dati Sessione',
                'help' => 'Session content (encrypted)',
            ],
            'size' => [
                'label' => 'Dimensione',
                'help' => 'Dimensione dei dati in memoria',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timing' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'When the session started',
            ],
            'last_activity' => [
                'label' => 'Last Activity',
                'help' => 'Last access to the session',
            ],
            'expires_at' => [
                'label' => 'Scadenza',
                'help' => 'Expected expiration time',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'View',
            'success' => 'Dettagli sessione visualizzati',
            'error' => 'Unable to view the session',
        ],
        'delete' => [
            'label' => 'Termina',
            'success' => 'Session terminated successfully',
            'error' => 'Unable to terminate the session',
            'confirm' => 'Are you sure you want to terminate this session?',
        ],
        'delete_all' => [
            'label' => 'Terminate All',
            'success' => 'All sessions terminated',
            'error' => 'Unable to terminate all sessions',
            'confirm' => 'Are you sure you want to terminate all sessions?',
        ],
        'delete_expired' => [
            'label' => 'Pulisci Scadute',
            'success' => 'Sessioni scadute rimosse',
            'error' => 'Unable to remove expired sessions',
        ],
        'refresh' => [
            'label' => 'Refresh',
            'success' => 'Session list refreshed',
            'error' => 'Unable to refresh the list',
        ],
    ],
    'messages' => [
        'status' => [
            'active' => 'Active session',
            'expired' => 'Sessione scaduta',
            'idle' => 'Sessione inattiva',
            'terminated' => 'Sessione terminata',
        ],
        'errors' => [
            'not_found' => 'Session not found',
            'invalid' => 'Invalid session',
            'expired' => 'Sessione scaduta',
            'permission' => 'Permessi insufficienti',
            'delete_current' => 'Unable to terminate the current session',
        ],
        'warnings' => [
            'delete_current' => 'You are about to terminate your current session',
            'delete_all' => 'All users will be logged out',
            'inactivity' => 'The session will expire soon due to inactivity',
            'multiple_sessions' => 'Multiple sessions detected for the same user',
        ],
        'info' => [
            'cleanup_scheduled' => 'Pulizia automatica programmata',
            'session_extended' => 'Durata sessione estesa',
            'activity_detected' => 'New activity detected',
        ],
    ],
    'settings' => [
        'lifetime' => [
            'label' => 'Durata Sessione',
            'help' => 'Maximum inactivity time',
            'options' => [
                120 => '2 ore',
                240 => '4 ore',
                480 => '8 ore',
                720 => '12 ore',
                1440 => '1 giorno',
                10080 => '1 settimana',
            ],
        ],
        'security' => [
            'secure' => [
                'label' => 'HTTPS Obbligatorio',
                'help' => 'Richiedi connessione sicura',
            ],
            'same_site' => [
                'label' => 'Politica Same Site',
                'help' => 'Cookie access restrictions',
                'options' => [
                    'lax' => 'Lax (consigliato)',
                    'strict' => 'Strict (more secure)',
                    'none' => 'None (less secure)',
                ],
            ],
            'http_only' => [
                'label' => 'HTTP only',
                'help' => 'Previeni accesso JavaScript',
            ],
        ],
        'storage' => [
            'driver' => [
                'label' => 'Driver',
                'help' => 'Storage system',
                'options' => [
                    'file' => 'File System',
                    'redis' => 'Redis',
                    'database' => 'Database',
                    'array' => 'Array (test)',
                ],
            ],
            'cleanup' => [
                'label' => 'Pulizia Automatica',
                'help' => 'Rimozione sessioni scadute',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
