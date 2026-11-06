<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Correo electrónico',
            'placeholder' => 'nombre@ejemplo.es',
            'helper_text' => 'Correo usado para registrarte en los servicios online',
            'tooltip' => 'Introduce el correo de tu cuenta',
            'description' => 'Campo de correo para la autenticación',
        ],
        'password' => [
            'label' => 'Contraseña',
            'placeholder' => 'Introduce tu contraseña',
            'helper_text' => '',
            'tooltip' => 'Contraseña de la cuenta',
            'description' => 'Campo de contraseña para la autenticación',
        ],
        'remember' => [
            'label' => 'Recuérdame',
            'placeholder' => '',
            'helper_text' => 'Mantener la sesión iniciada en este dispositivo',
            'tooltip' => 'Sesión prolongada',
            'description' => 'Opción para recordar el acceso',
        ],
    ],
    'actions' => [
        'hidePassword' => [
            'label' => 'Ocultar contraseña',
            'tooltip' => 'Ocultar contraseña',
            'icon' => 'hidePassword',
        ],
        'showPassword' => [
            'label' => 'Mostrar contraseña',
            'tooltip' => 'Mostrar contraseña',
            'icon' => 'showPassword',
        ],
    ],
    'ui' => [
        'errors_title' => 'Revisa los datos introducidos',
        'login_button' => 'Iniciar sesión',
        'forgot_password' => '¿Olvidaste tu contraseña?',
    ],
];
