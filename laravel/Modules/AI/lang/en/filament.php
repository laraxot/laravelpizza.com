<?php

declare(strict_types=1);

return [
    'pages' => [
        'artisan-commands-manager' => [
            'navigation_label' => 'Artisan Management',
            'navigation_group' => 'Sistema',
            'navigation_icon' => 'xot::terminal',
            'title' => 'Artisan Commands Manager',
            'commands' => [
                'migrate' => [
                    'label' => 'Migrate Database',
                    'icon' => 'xot::database-update',
                ],
                'filament_upgrade' => [
                    'label' => 'Upgrade Filament',
                    'icon' => 'xot::upgrade',
                ],
                'filament_optimize' => [
                    'label' => 'Optimize Filament',
                    'icon' => 'xot::optimize',
                ],
                'view_cache' => [
                    'label' => 'Cache Views',
                    'icon' => 'xot::view-cache',
                ],
                'config_cache' => [
                    'label' => 'Cache Config',
                    'icon' => 'xot::config-cache',
                ],
                'route_cache' => [
                    'label' => 'Cache Routes',
                    'icon' => 'xot::route-cache',
                ],
                'event_cache' => [
                    'label' => 'Cache Events',
                    'icon' => 'xot::event-cache',
                ],
                'queue_restart' => [
                    'label' => 'Restart Queue',
                    'icon' => 'xot::queue-restart',
                ],
            ],
            'status' => [
                'completed' => 'Completed',
                'failed' => 'Failed',
                'waiting' => 'In attesa dell\'output...',
            ],
            'messages' => [
                'command_started' => 'Command started',
                'command_completed' => 'The :command command ran successfully',
                'command_failed' => 'The :command command failed',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
