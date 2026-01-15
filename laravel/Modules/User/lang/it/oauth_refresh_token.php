<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'OAuth Refresh Token',
        'plural' => 'OAuth Refresh Tokens',
        'label' => 'OAuth Refresh Tokens',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 27,
    ],
    'label' => 'Refresh Token OAuth',
    'plural_label' => 'Refresh Token OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Token di accesso',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
            'success' => 'Refresh token revocato con successo',
        ],
    ],
];
