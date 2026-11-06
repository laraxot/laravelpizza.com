<?php

declare(strict_types=1);

return [
    'fields' => [
        'first_name' => [
            'label' => 'Nombre',
            'placeholder' => 'María',
            'helper_text' => 'Tu nombre de pila',
            'description' => 'Nombre',
        ],
        'last_name' => [
            'label' => 'Apellidos',
            'placeholder' => 'García',
            'helper_text' => 'Tus apellidos',
            'description' => 'Apellidos',
        ],
        'email' => [
            'label' => 'Correo electrónico',
            'placeholder' => 'nombre@ejemplo.es',
            'helper_text' => 'Usa el correo con el que iniciarás sesión.',
            'description' => 'Correo',
        ],
        'password' => [
            'label' => 'Contraseña',
            'placeholder' => 'Introduce una contraseña segura',
            'helper_text' => 'Mínimo 12 caracteres, una mayúscula, una minúscula, un número y un símbolo.',
            'description' => 'Contraseña de acceso',
        ],
        'password_confirmation' => [
            'label' => 'Confirmar contraseña',
            'placeholder' => 'Repite la contraseña',
            'helper_text' => 'Debe coincidir con la contraseña de arriba.',
            'description' => 'Confirmar contraseña',
        ],
        'remember' => [
            'label' => 'Recuérdame',
            'placeholder' => '',
            'helper_text' => 'Sesión prolongada en un dispositivo de confianza',
            'description' => 'Mantener la sesión iniciada en este dispositivo',
        ],
    ],
    'actions' => [
        'showPassword' => [
            'label' => 'Mostrar contraseña',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Mostrar contraseña',
        ],
        'hidePassword' => [
            'label' => 'Ocultar contraseña',
            'icon' => 'heroicon-o-eye-slash',
            'tooltip' => 'Ocultar contraseña',
        ],
    ],
];
