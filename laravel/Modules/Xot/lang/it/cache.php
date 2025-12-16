<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Cache',
        'plural' => 'Cache',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione della cache del sistema',
        ],
        'label' => 'cache',
        'sort' => 29,
        'icon' => 'xot-cache',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci la chiave',
            'help' => 'Chiave identificativa della cache',
        ],
        'value' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore memorizzato nella cache',
        ],
        'ttl' => [
            'label' => 'Tempo di Vita',
            'placeholder' => 'Inserisci il TTL in minuti',
            'help' => 'Tempo di permanenza in cache (in minuti)',
        ],
        'tags' => [
            'label' => 'Tag',
            'placeholder' => 'Seleziona i tag',
            'help' => 'Tag per raggruppare elementi della cache',
        ],
        'size' => [
            'label' => 'Dimensione',
            'help' => 'Dimensione occupata in memoria',
        ],
        'driver' => [
            'label' => 'Driver',
            'help' => 'Driver di cache utilizzato',
            'options' => [
                'file' => 'File System',
                'redis' => 'Redis',
                'memcached' => 'Memcached',
                'array' => 'Array',
            ],
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di inserimento in cache',
        ],
        'expires_at' => [
            'label' => 'Data Scadenza',
            'help' => 'Data di scadenza della cache',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
    ],
    'actions' => [
        'clear' => [
            'label' => 'Svuota Cache',
            'success' => 'Cache svuotata con successo',
            'error' => 'Errore durante lo svuotamento della cache',
        ],
        'refresh' => [
            'label' => 'Aggiorna',
            'success' => 'Cache aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della cache',
        ],
        'optimize' => [
            'label' => 'Ottimizza',
            'success' => 'Cache ottimizzata con successo',
            'error' => 'Errore durante l\'ottimizzazione della cache',
        ],
        'warm' => [
            'label' => 'Preriscalda',
            'success' => 'Cache preriscaldata con successo',
            'error' => 'Errore durante il preriscaldamento della cache',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'La chiave è obbligatoria',
                'unique' => 'Questa chiave è già presente in cache',
            ],
            'ttl' => [
                'numeric' => 'Il TTL deve essere un numero',
                'min' => 'Il TTL deve essere maggiore di zero',
            ],
        ],
        'errors' => [
            'driver_not_supported' => 'Driver di cache non supportato',
            'key_not_found' => 'Chiave non trovata in cache',
            'storage_full' => 'Spazio cache esaurito',
            'connection_failed' => 'Connessione al server cache fallita',
        ],
        'info' => [
            'auto_cleanup' => 'Gli elementi scaduti verranno rimossi automaticamente',
            'memory_usage' => 'Utilizzo memoria cache: :usage',
            'hit_ratio' => 'Rapporto hit/miss: :ratio',
        ],
    ],
    'pages' => [
        'health_check_results' => [
            'buttons' => [
                'refresh' => 'Aggiorna',
            ],
            'heading' => 'Stato del Sistema',
            'navigation' => [
                'group' => 'Impostazioni',
                'label' => 'Stato del Sistema',
            ],
            'notifications' => [
                'check_results' => 'Risultati verifica da',
            ],
        ],
    ],
];
