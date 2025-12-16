<?php

return [
    'redirect_domains' => [
        '*',
        // 'https://example.com',
    ],

    'mcp_servers' => [
        // Filesystem server for file operations
        'filesystem' => [
            'enabled' => env('MCP_FILESYSTEM_ENABLED', true),
            'transport' => 'stdio', // or 'http'
            'options' => [
                'root' => base_path(),
                'read_only' => false,
            ],
        ],

        // Database server for database operations
        'database' => [
            'enabled' => env('MCP_DATABASE_ENABLED', true),
            'driver' => env('DB_CONNECTION', 'mysql'),
            'transport' => 'stdio',
            'options' => [
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', 3306),
                'database' => env('DB_DATABASE', 'laravel'),
                'username' => env('DB_USERNAME', 'root'),
                'password' => env('DB_PASSWORD', ''),
            ],
        ],

        // Git server for version control operations
        'git' => [
            'enabled' => env('MCP_GIT_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'repository_path' => base_path(),
                'auto_fetch' => true,
            ],
        ],

        // Laravel Artisan server for Laravel-specific commands
        'artisan' => [
            'enabled' => env('MCP_ARTISAN_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'laravel_root' => base_path(),
                'allowed_commands' => [
                    'list',
                    'route:list',
                    'config:cache',
                    'cache:clear',
                    'migrate:status',
                    'migrate',
                    'migrate:rollback',
                    'db:seed',
                    'make:*',
                    'queue:work',
                    'storage:link',
                    'vendor:publish',
                    // Xot specific commands
                    'module:make',
                    'module:enable',
                    'module:disable',
                    'module:list',
                ],
            ],
        ],

        // PHPStan server for static analysis
        'phpstan' => [
            'enabled' => env('MCP_PHPSTAN_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'project_root' => base_path(),
                'config_file' => base_path('phpstan.neon'),
                'memory_limit' => '1G',
            ],
        ],

        // Composer server for dependency management
        'composer' => [
            'enabled' => env('MCP_COMPOSER_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'project_root' => base_path(),
                'composer_path' => base_path('composer.json'),
            ],
        ],

        // Puppeteer server for browser automation
        'puppeteer' => [
            'enabled' => env('MCP_PUPPETEER_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'project_root' => base_path(),
                'timeout' => 60000, // 60 seconds timeout
            ],
        ],

        // Xot-specific servers
        'xot-data' => [
            'enabled' => env('MCP_XOT_DATA_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'project_root' => base_path(),
                'data_classes_path' => base_path('Modules/Xot/Datas'),
                'allowed_operations' => [
                    'analyze',
                    'validate',
                    'generate',
                ],
            ],
        ],

        'xot-actions' => [
            'enabled' => env('MCP_XOT_ACTIONS_ENABLED', true),
            'transport' => 'stdio',
            'options' => [
                'project_root' => base_path(),
                'actions_path' => base_path('Modules/Xot/Actions'),
                'allowed_operations' => [
                    'execute',
                    'validate',
                    'analyze',
                ],
            ],
        ],
    ],

    'security' => [
        // Whether to require authentication for MCP servers
        'require_auth' => env('MCP_REQUIRE_AUTH', false),

        // List of allowed IP addresses for MCP access
        'allowed_ips' => [
            // '127.0.0.1',
            // '::1',
        ],

        // Rate limiting for MCP requests
        'rate_limiting' => [
            'enabled' => true,
            'requests_per_minute' => 60,
        ],
    ],

    'logging' => [
        'enabled' => env('MCP_LOGGING_ENABLED', true),
        'channel' => env('MCP_LOG_CHANNEL', 'stack'),
        'level' => env('MCP_LOG_LEVEL', 'info'),
    ],
];