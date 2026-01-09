<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => 'Security',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'redirect' => [
            'label' => 'Redirect',
        ],
        'personal_access_client' => [
            'label' => 'Personal Access Client',
        ],
        'password_client' => [
            'label' => 'Password Client',
        ],
        'revoked' => [
            'label' => 'Revoked',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => 'Create Client',
        ],
        'revoke' => [
            'label' => 'Revoke',
        ],
    ],
];