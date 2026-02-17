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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'host' => [
            'label' => 'Host',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => 'Port',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => 'Username',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Password',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => 'Encryption',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => 'From Address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => 'From Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => 'Last Tested At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'description' => 'HTML Body',
            'helper_text' => 'HTML content of the email',
            'label' => '',
            'tooltip' => '',
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
