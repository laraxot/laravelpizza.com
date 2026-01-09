<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token de actualización OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Token de actualización OAuth',
    'plural_label' => 'Tokens de actualización OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Token de acceso',
        ],
        'revoked' => [
            'label' => 'Revocado',
        ],
        'expires_at' => [
            'label' => 'Expira en',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revocar',
        ],
    ],
];