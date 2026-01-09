<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Usuario Socialite',
        'group' => 'Autenticación',
        'icon' => 'heroicon-o-user-group',
        'sort' => 40,
    ],
    'label' => 'Usuario Socialite',
    'plural_label' => 'Usuarios Socialite',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'provider' => [
            'label' => 'Proveedor',
        ],
        'provider_id' => [
            'label' => 'ID del proveedor',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'avatar' => [
            'label' => 'Avatar',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'refresh_token' => [
            'label' => 'Token de actualización',
        ],
        'expires_at' => [
            'label' => 'Expira en',
        ],
    ],
    'actions' => [
        'link_provider' => [
            'label' => 'Vincular proveedor',
        ],
        'unlink_provider' => [
            'label' => 'Desvincular proveedor',
        ],
    ],
];