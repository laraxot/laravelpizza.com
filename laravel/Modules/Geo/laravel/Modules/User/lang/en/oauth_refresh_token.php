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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'access_token_id' => [
            'label' => 'Access Token',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'revoked' => [
            'label' => 'Revoked',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_at' => [
            'label' => 'Expires At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoke',
        ],
    ],
];
