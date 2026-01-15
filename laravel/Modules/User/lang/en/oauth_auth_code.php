<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Auth Code',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'OAuth Auth Code',
    'plural_label' => 'OAuth Auth Codes',
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
        'view_scopes' => [
            'label' => 'View Scopes',
        ],
    ],
];
