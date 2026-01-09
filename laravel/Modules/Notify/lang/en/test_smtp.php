<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SMTP Test',
        'group' => 'Notifications',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'SMTP Test',
    'plural_label' => 'SMTP Tests',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'host' => [
            'label' => 'Host',
        ],
        'port' => [
            'label' => 'Port',
        ],
        'username' => [
            'label' => 'Username',
        ],
        'password' => [
            'label' => 'Password',
        ],
        'encryption' => [
            'label' => 'Encryption',
        ],
        'from_address' => [
            'label' => 'From Address',
        ],
        'from_name' => [
            'label' => 'From Name',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'last_tested_at' => [
            'label' => 'Last Tested At',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'body_html' => [
            'description' => 'HTML Body',
            'helper_text' => 'HTML content of the email',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Logout',
            'icon' => 'logout',
            'label' => 'Logout',
        ],
        'emailFormActions' => [
            'tooltip' => 'Email Form Actions',
            'icon' => 'emailFormActions',
            'label' => 'Email Form Actions',
        ],
        'profile' => [
            'tooltip' => 'Profile',
            'icon' => 'profile',
        ],
        'send_test_email' => [
            'label' => 'Send Test Email',
        ],
        'test_connection' => [
            'label' => 'Test Connection',
        ],
    ],
];
