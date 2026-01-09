<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Authentication Logs',
        'group' => 'Security',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 36,
    ],
    'label' => 'Authentication Log',
    'plural_label' => 'Authentication Logs',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'ip_address' => [
            'label' => 'IP Address',
        ],
        'user_agent' => [
            'label' => 'User Agent',
        ],
        'login_at' => [
            'label' => 'Login At',
        ],
        'logout_at' => [
            'label' => 'Logout At',
        ],
        'login_method' => [
            'label' => 'Login Method',
        ],
        'success' => [
            'label' => 'Success',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'View Details',
        ],
        'export_logs' => [
            'label' => 'Export Logs',
        ],
        'reorderRecords' => [
            'tooltip' => 'Reorder records',
        ],
    ],
];
