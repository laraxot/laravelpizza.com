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
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'authenticatable_type' => [
            'label' => 'Authenticatable Type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'authenticatable.name' => [
            'label' => 'User',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ip_address' => [
            'label' => 'IP Address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user_agent' => [
            'label' => 'User Agent',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_successful' => [
            'label' => 'Success',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'login_at' => [
            'label' => 'Login Time',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'logout_at' => [
            'label' => 'Logout Time',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'cleared_by_user' => [
            'label' => 'Cleared by User',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'authenticatable_id' => [
            'label' => 'Authenticatable ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_user' => [
            'label' => 'View User',
            'icon' => 'heroicon-o-user',
        ],
    ],
];
