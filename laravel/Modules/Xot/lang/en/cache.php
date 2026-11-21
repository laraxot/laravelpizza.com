<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Cache',
        'plural' => 'Cache',
        'group' => [
            'name' => 'Sistema',
            'description' => 'System cache management',
        ],
        'label' => 'Cache',
        'sort' => '29',
        'icon' => 'xot-cache',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Enter the key',
            'help' => 'Cache identifier key',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'Value',
            'placeholder' => 'Enter the value',
            'help' => 'Value stored in the cache',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ttl' => [
            'label' => 'Time to Live',
            'placeholder' => 'Enter the TTL in minutes',
            'help' => 'Tempo di permanenza in cache (in minuti)',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'tags' => [
            'label' => 'Tag',
            'placeholder' => 'Select tags',
            'help' => 'Tags to group cache items',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'size' => [
            'label' => 'Dimensione',
            'help' => 'Dimensione occupata in memoria',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'driver' => [
            'label' => 'Driver',
            'help' => 'Cache driver in use',
            'options' => [
                'file' => 'File System',
                'redis' => 'Redis',
                'memcached' => 'Memcached',
                'array' => 'Array',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di inserimento in cache',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_at' => [
            'label' => 'Data Scadenza',
            'help' => 'Cache expiration date',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'openFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'clear' => [
            'label' => 'Svuota Cache',
            'success' => 'Cache cleared successfully',
            'error' => 'Error while clearing the cache',
        ],
        'refresh' => [
            'label' => 'Refresh',
            'success' => 'Cache refreshed successfully',
            'error' => 'Error while refreshing the cache',
        ],
        'optimize' => [
            'label' => 'Ottimizza',
            'success' => 'Cache optimized successfully',
            'error' => 'Error while optimizing the cache',
        ],
        'warm' => [
            'label' => 'Preriscalda',
            'success' => 'Cache warmed up successfully',
            'error' => 'Error while warming up the cache',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'The key is required',
                'unique' => 'This key already exists in the cache',
            ],
            'ttl' => [
                'numeric' => 'The TTL must be a number',
                'min' => 'The TTL must be greater than zero',
            ],
        ],
        'errors' => [
            'driver_not_supported' => 'Unsupported cache driver',
            'key_not_found' => 'Key not found in the cache',
            'storage_full' => 'Spazio cache esaurito',
            'connection_failed' => 'Connessione al server cache fallita',
        ],
        'info' => [
            'auto_cleanup' => 'Expired items will be removed automatically',
            'memory_usage' => 'Utilizzo memoria cache: :usage',
            'hit_ratio' => 'Rapporto hit/miss: :ratio',
        ],
    ],
    'pages' => [
        'health_check_results' => [
            'buttons' => [
                'refresh' => 'Refresh',
            ],
            'heading' => 'System Status',
            'navigation' => [
                'group' => 'Settings',
                'label' => 'System Status',
            ],
            'notifications' => [
                'check_results' => 'Check results from',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
