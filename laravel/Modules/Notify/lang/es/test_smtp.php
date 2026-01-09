<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Prueba SMTP',
        'group' => 'Notificaciones',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'Prueba SMTP',
    'plural_label' => 'Pruebas SMTP',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
        'host' => [
            'label' => 'Host',
        ],
        'port' => [
            'label' => 'Puerto',
        ],
        'username' => [
            'label' => 'Nombre de usuario',
        ],
        'password' => [
            'label' => 'Contraseña',
        ],
        'encryption' => [
            'label' => 'Cifrado',
        ],
        'from_address' => [
            'label' => 'Dirección de origen',
        ],
        'from_name' => [
            'label' => 'Nombre de origen',
        ],
        'status' => [
            'label' => 'Estado',
        ],
        'last_tested_at' => [
            'label' => 'Última prueba en',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
    ],
    'actions' => [
        'send_test_email' => [
            'label' => 'Enviar correo de prueba',
        ],
        'test_connection' => [
            'label' => 'Probar conexión',
        ],
    ],
];
