<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => 'Seguridad',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'client_id' => [
            'label' => 'ID de cliente',
        ],
        'client_secret' => [
            'label' => 'Clave secreta del cliente',
        ],
        'redirect' => [
            'label' => 'Redirección',
        ],
        'personal_access_client' => [
            'label' => 'Cliente de acceso personal',
        ],
        'password_client' => [
            'label' => 'Cliente de contraseña',
        ],
        'revoked' => [
            'label' => 'Revocado',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => 'Crear cliente',
        ],
        'revoke' => [
            'label' => 'Revocar',
        ],
    ],
];
