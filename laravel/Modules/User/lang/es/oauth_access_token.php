<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Token de acceso OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 33,
    ],
    'label' => 'Token de acceso OAuth',
    'plural_label' => 'Tokens de acceso OAuth',
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
