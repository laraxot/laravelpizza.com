<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Cliente OAuth',
        'group' => '',
        'icon' => 'heroicon-o-key',
        'sort' => 46,
    ],
    'label' => 'Cliente OAuth',
    'plural_label' => 'Clientes OAuth',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'secret' => [
            'label' => 'Secreto',
        ],
        'provider' => [
            'label' => 'Proveedor',
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
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
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
