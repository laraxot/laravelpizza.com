<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Password Reset',
        'group' => 'Security',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Password Reset',
    'plural_label' => 'Password Resets',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'token' => [
            'label' => 'Token',
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
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Resend Email',
        ],
        'view_request' => [
            'label' => 'View Request',
        ],
    ],
];
