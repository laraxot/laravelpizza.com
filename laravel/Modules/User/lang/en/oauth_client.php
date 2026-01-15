<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Client',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 46,
    ],
    'label' => 'OAuth Client',
    'plural_label' => 'OAuth Clients',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'secret' => [
            'label' => 'Secret',
        ],
        'provider' => [
            'label' => 'Provider',
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
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
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
