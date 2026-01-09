<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Reset Password',
        'plural' => 'Reset Password',
        'icon' => 'heroicon-o-key',
        'group' => 'Sicurezza',
        'sort' => 40,
    ],
    'label' => 'Reset Password',
    'plural_label' => 'Reset Password',
    'fields' => [
        'email' => ['label' => 'Email'],
        'token' => ['label' => 'Token'],
        'created_at' => ['label' => 'Creato il'],
    ],
];
