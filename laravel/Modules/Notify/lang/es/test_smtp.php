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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nombre',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'host' => [
            'label' => 'Host',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => 'Puerto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => 'Nombre de Usuario',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Contraseña',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => 'Cifrado',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => 'Dirección Remitente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => 'Nombre Remitente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Estado',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => 'Última Prueba En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body_html' => [
            'description' => 'Cuerpo HTML',
            'helper_text' => 'Contenido HTML del correo',
            'label' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Cerrar sesión',
            'icon' => 'logout',
            'label' => 'Cerrar sesión',
        ],
        'emailFormActions' => [
            'tooltip' => 'Acciones del Formulario de Correo',
            'icon' => 'emailFormActions',
            'label' => 'Acciones del Formulario de Correo',
        ],
        'profile' => [
            'tooltip' => 'Perfil',
            'icon' => 'profile',
        ],
        'send_test_email' => [
            'label' => 'Enviar Correo de Prueba',
        ],
        'test_connection' => [
            'label' => 'Probar Conexión',
        ],
    ],
];
