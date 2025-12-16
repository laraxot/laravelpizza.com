<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | MCP Servers Configuration
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione dei server MCP disponibili nel sistema per il progetto Laravel Pizza.
     * | Ogni server ha un comando e argomenti specifici per facilitare lo sviluppo.
     * |
     */

    'servers' => [
        'filesystem' => [
            'command' => 'npx',
            'args' => ['-y', '@modelcontextprotocol/server-filesystem'],
            'description' => 'Gestione file e directory del progetto Laravel Pizza',
            'env' => [
                'MCP_FILESYSTEM_ROOT' => base_path(),
                'MCP_FILESYSTEM_READ_ONLY' => false,
            ],
        ],
        'memory' => [
            'command' => 'npx',
            'args' => ['-y', '@modelcontextprotocol/server-memory'],
            'description' => 'Memoria temporanea per lo sviluppo',
            'env' => [
                'MCP_MEMORY_CAPACITY' => 1000,
                'MCP_MEMORY_TTL' => 3600,
            ],
        ],
        'fetch' => [
            'command' => 'npx',
            'args' => ['-y', '@modelcontextprotocol/server-fetch'],
            'description' => 'Richieste HTTP esterne per testing API',
            'env' => [
                'MCP_FETCH_TIMEOUT' => 30000,
                'MCP_FETCH_MAX_REDIRECTS' => 5,
            ],
        ],
        'mysql' => [
            'command' => 'npx',
            'args' => ['-y', '@modelcontextprotocol/server-mysql'],
            'description' => 'Accesso al database MySQL del progetto pizza',
            'env' => [
                'MCP_MYSQL_HOST' => env('DB_HOST', '127.0.0.1'),
                'MCP_MYSQL_PORT' => env('DB_PORT', 3306),
                'MCP_MYSQL_USER' => env('DB_USERNAME', 'root'),
                'MCP_MYSQL_PASSWORD' => env('DB_PASSWORD', ''),
                'MCP_MYSQL_DATABASE' => env('DB_DATABASE', 'laravelpizza'),
            ],
        ],
        'redis' => [
            'command' => 'npx',
            'args' => ['-y', '@modelcontextprotocol/server-redis'],
            'description' => 'Gestione cache e sessioni Redis',
            'env' => [
                'MCP_REDIS_HOST' => env('REDIS_HOST', '127.0.0.1'),
                'MCP_REDIS_PORT' => env('REDIS_PORT', 6379),
                'MCP_REDIS_PASSWORD' => env('REDIS_PASSWORD', null),
                'MCP_REDIS_DATABASE' => env('REDIS_DB', 0),
            ],
        ],
        'laravel-artisan' => [
            'command' => 'php',
            'args' => ['artisan'],
            'description' => 'Comandi Artisan di Laravel per gestione del progetto',
            'env' => [
                'MCP_LARAVEL_ENV' => env('APP_ENV', 'production'),
                'MCP_LARAVEL_DEBUG' => config('app.debug', false),
            ],
        ],
        'composer' => [
            'command' => 'composer',
            'args' => [],
            'description' => 'Gestione delle dipendenze PHP',
            'env' => [
                'MCP_COMPOSER_BIN' => base_path('vendor/bin'),
            ],
        ],
        'phpstan' => [
            'command' => 'php',
            'args' => ['vendor/bin/phpstan'],
            'description' => 'Analisi statica del codice PHP',
            'env' => [
                'MCP_PHPSTAN_CONFIG' => base_path('phpstan.neon'),
            ],
        ],
        'npm' => [
            'command' => 'npm',
            'args' => [],
            'description' => 'Gestione delle dipendenze JavaScript e build assets',
            'env' => [
                'MCP_NPM_WORKSPACE' => base_path(),
            ],
        ],
        'git' => [
            'command' => 'git',
            'args' => [],
            'description' => 'Gestione del controllo versione del progetto',
            'env' => [
                'MCP_GIT_WORKSPACE' => base_path(),
            ],
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | MCP Model Contexts
     * |--------------------------------------------------------------------------
     * |
     * | Definizione dei contesti per i modelli del sistema del progetto Laravel Pizza.
     * | Ogni contesto definisce trait, relazioni e validazioni richieste.
     * |
     */

    'contexts' => [
        'User' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'Notifiable',
                'HasUuids',
            ],
            'relationships' => [
                'orders',
                'addresses',
                'reviews',
            ],
            'table' => 'users',
            'type_column' => 'type',
            'description' => 'Utente base del sistema pizza',
        ],
        'Customer' => [
            'extends' => 'User',
            'type' => 'child',
            'traits' => [
                'HasParent',
            ],
            'context' => 'pizza_app',
            'validations' => [
                'customer_phone',
                'customer_email',
            ],
            'description' => 'Cliente del sistema pizza',
        ],
        'Pizza' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'ingredients',
                'orders',
                'reviews',
            ],
            'table' => 'pizzas',
            'description' => 'Modello per le pizze del menu',
        ],
        'Order' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'user',
                'pizzas',
                'order_items',
                'address',
            ],
            'table' => 'orders',
            'description' => 'Modello per gli ordini dei clienti',
        ],
        'OrderItem' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'order',
                'pizza',
            ],
            'table' => 'order_items',
            'description' => 'Elementi di un ordine',
        ],
        'Ingredient' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'pizzas',
                'allergens',
            ],
            'table' => 'ingredients',
            'description' => 'Ingredienti utilizzati nelle pizze',
        ],
        'Category' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'pizzas',
            ],
            'table' => 'categories',
            'description' => 'Categorie delle pizze',
        ],
        'Address' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'user',
                'orders',
            ],
            'table' => 'addresses',
            'description' => 'Indirizzi di consegna',
        ],
        'Review' => [
            'type' => 'base',
            'traits' => [
                'HasFactory',
                'HasUuids',
            ],
            'relationships' => [
                'user',
                'pizza',
            ],
            'table' => 'reviews',
            'description' => 'Recensioni dei prodotti',
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | MCP Validation Rules
     * |--------------------------------------------------------------------------
     * |
     * | Regole di validazione per i contesti dei modelli del progetto pizza.
     * |
     */

    'validation' => [
        'strict' => true,
        'log_violations' => true,
        'throw_exceptions' => false,
        'pizza_price_positive' => true,
        'order_validation_enabled' => true,
        'user_email_unique' => true,
        'ingredient_allergen_check' => true,
    ],
    
    /*
     * |--------------------------------------------------------------------------
     * | MCP Development Tools
     * |--------------------------------------------------------------------------
     * |
     * | Configurazione degli strumenti di sviluppo specifici per il progetto.
     * |
     */

    'development_tools' => [
        'debug_mode' => env('APP_DEBUG', false),
        'log_queries' => true,
        'log_mcp_requests' => true,
        'performance_monitoring' => true,
    ],
];