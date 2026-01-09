<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token di aggiornamento OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Token di aggiornamento OAuth',
    'plural_label' => 'Token di aggiornamento OAuth',
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
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revoca',
        ],
    ],
];