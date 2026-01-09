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
        'email' => ['label' => 'Email'],
        'token' => ['label' => 'Token'],
        'created_at' => ['label' => 'Created At'],
    ],
];
