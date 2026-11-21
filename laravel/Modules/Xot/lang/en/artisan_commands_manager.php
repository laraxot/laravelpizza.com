<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Comandi Artisan',
        'plural' => 'Comandi Artisan',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Artisan command management',
        ],
        'sort' => '28',
        'label' => 'Comandi Artisan',
        'icon' => 'heroicon-o-command-line',
    ],
    'pages' => [
        'artisan-commands' => [
            'title' => 'Artisan Commands Manager',
            'description' => 'Run and manage Artisan commands',
            'commands' => [
                'migrate' => [
                    'label' => 'Migrazione Database',
                    'description' => 'Runs the database migrations',
                ],
                'optimize' => [
                    'label' => 'Ottimizzazione',
                    'description' => 'Optimizes application performance',
                ],
                'cache' => [
                    'label' => 'Cache Management',
                    'description' => 'Commands for managing the cache',
                ],
            ],
            'notifications' => [
                'success' => 'Command executed successfully',
                'error' => 'Error while running the command',
            ],
        ],
    ],
    'title' => 'Artisan Commands Manager',
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
