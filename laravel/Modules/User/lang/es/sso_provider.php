<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Proveedor SSO',
        'group' => 'Autenticación',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 41,
    ],
    'label' => 'Proveedor SSO',
    'plural_label' => 'Proveedores SSO',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'provider' => [
            'label' => 'Proveedor',
        ],
        'client_id' => [
            'label' => 'ID del cliente',
        ],
        'client_secret' => [
            'label' => 'Clave secreta del cliente',
        ],
        'redirect' => [
            'label' => 'Redirección',
        ],
        'active' => [
            'label' => 'Activo',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => 'Activar',
        ],
        'deactivate' => [
            'label' => 'Desactivar',
        ],
        'test_connection' => [
            'label' => 'Probar conexión',
        ],
    ],
];