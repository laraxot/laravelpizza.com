<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'OAuth Refresh Token',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'OAuth Refresh Token',
    'plural_label' => 'OAuth Refresh Tokens',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Access Token',
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
    ],
];
