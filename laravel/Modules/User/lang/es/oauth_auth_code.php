<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Código de Autorización OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'label' => 'Código de Autorización OAuth',
    'plural_label' => 'Códigos de Autorización OAuth',
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
            'label' => 'Expira En',
        ],
    ],
    'actions' => [
        'revoke' => [
            'label' => 'Revocar',
        ],
        'view_scopes' => [
            'label' => 'Ver Ámbitos',
        ],
    ],
];
