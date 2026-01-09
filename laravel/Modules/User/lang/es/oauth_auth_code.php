<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Código de autorización OAuth',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'Código de autorización OAuth',
    'plural_label' => 'Códigos de autorización OAuth',
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
        'view_scopes' => [
            'label' => 'Ver ámbitos',
        ],
    ],
];