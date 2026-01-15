<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Access Token',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'OAuth Access Token',
    'plural_label' => 'OAuth Access Tokens',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'User',
        ],
        'client_id' => [
            'label' => 'Client',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'scopes' => [
            'label' => 'Scopes',
        ],
        'revoked' => [
            'label' => 'Revoked',
        ],
        'expires_at' => [
            'label' => 'Expires At',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoke',
        ],
        'refresh' => [
            'label' => 'Refresh',
        ],
    ],
];
