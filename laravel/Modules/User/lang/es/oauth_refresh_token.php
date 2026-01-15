<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token de Actualización OAuth',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Token de Actualización OAuth',
    'plural_label' => 'Tokens de Actualización OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Token de Acceso',
        ],
        'revoked' => [
            'label' => 'Revocado',
        ],
        'expires_at' => [
            'label' => 'Expira En',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revocar',
        ],
    ],
];
