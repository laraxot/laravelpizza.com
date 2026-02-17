<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Password Resets',
        'plural' => 'Password Resets',
        'icon' => 'heroicon-o-key',
        'group' => 'Security',
        'sort' => 40,
    ],
    'label' => 'Password Reset',
    'plural_label' => 'Password Resets',
    'fields' => [
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
    ],
];
