<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Tokens de Acceso OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Token de Acceso OAuth',
    'plural_label' => 'Tokens de Acceso OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'client_id' => [
            'label' => 'Cliente',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'scopes' => [
            'label' => 'Ámbitos',
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
        'refresh' => [
            'label' => 'Actualizar',
        ],
    ],
];
