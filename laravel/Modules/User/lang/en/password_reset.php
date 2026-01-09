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
        ],
        'email' => [
            'label' => 'Email',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'created_at' => [
            'label' => 'Created At',
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
