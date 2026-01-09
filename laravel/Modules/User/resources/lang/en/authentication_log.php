<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Authentication Logs',
        'plural' => 'Authentication Logs',
        'icon' => 'heroicon-o-shield-check',
        'group' => 'Security',
        'sort' => 30,
    ],
    'label' => 'Authentication Log',
    'plural_label' => 'Authentication Logs',
    'fields' => [
        'id' => ['label' => 'ID'],
        'authenticatable_type' => ['label' => 'Authenticatable Type'],
        'authenticatable.name' => ['label' => 'User'],
        'ip_address' => ['label' => 'IP Address'],
        'user_agent' => ['label' => 'User Agent'],
        'login_successful' => ['label' => 'Success'],
        'login_at' => ['label' => 'Login Time'],
        'logout_at' => ['label' => 'Logout Time'],
        'cleared_by_user' => ['label' => 'Cleared by User'],
        'authenticatable_id' => ['label' => 'Authenticatable ID'],
    ],
    'actions' => [
        'view_user' => [
            'label' => 'View User',
            'icon' => 'heroicon-o-user',
        ],
    ],
];
