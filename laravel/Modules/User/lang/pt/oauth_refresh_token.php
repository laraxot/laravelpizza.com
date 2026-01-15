<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token de Atualização OAuth',
        'group' => '',
        'icon' => 'heroicon-o-arrow-path',
        'sort' => 34,
    ],
    'label' => 'Token de Atualização OAuth',
    'plural_label' => 'Tokens de Atualização OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'access_token_id' => [
            'label' => 'Token de Acesso',
        ],
        'revoked' => [
            'label' => 'Revogado',
        ],
        'expires_at' => [
            'label' => 'Expira Em',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revogar',
        ],
    ],
];
