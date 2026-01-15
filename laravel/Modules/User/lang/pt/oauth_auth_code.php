<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Código de Autorização OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'Código de Autorização OAuth',
    'plural_label' => 'Códigos de Autorização OAuth',
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
        'view_scopes' => [
            'label' => 'Ver Escopos',
        ],
    ],
];
