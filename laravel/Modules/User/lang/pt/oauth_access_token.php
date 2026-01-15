<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token de Acesso OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Token de Acesso OAuth',
    'plural_label' => 'Tokens de Acesso OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuário',
        ],
        'client_id' => [
            'label' => 'Cliente',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'scopes' => [
            'label' => 'Escopos',
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
        'refresh' => [
            'label' => 'Atualizar',
        ],
    ],
];
