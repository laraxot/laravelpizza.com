<?php

declare(strict_types=1);

return [
    'register' => [
        'page' => [
            'title' => 'Registro',
        ],
        'sign_in' => [
            'label' => 'inicia sesión en tu cuenta',
        ],
    ],
    'sections' => [
        'register' => [
            'title' => 'Crear una cuenta nueva',
        ],
        'password_confirm' => [
            'title' => 'Confirma tu contraseña',
            'description' => 'Confirma tu contraseña antes de continuar',
        ],
        'verify' => [
            'title' => 'Verifica tu dirección de correo electrónico',
        ],
    ],
    'password_confirm' => [
        'submit' => [
            'label' => 'Confirmar contraseña',
        ],
    ],
    'password_email' => [
        'send_link' => [
            'description' => 'Enviar enlace para restablecer la contraseña',
        ],
    ],
    'common' => [
        'confirm_password' => [
            'label' => 'Confirmar contraseña',
        ],
        'or' => [
            'label' => 'O',
        ],
        'name' => [
            'label' => 'Nombre',
        ],
    ],
    'verify' => [
        'sign_out' => [
            'label' => 'cerrar sesión',
        ],
        'resent' => [
            'message' => 'Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.',
        ],
        'check_email' => [
            'description' => 'Antes de continuar, revisa tu correo electrónico para encontrar el enlace de verificación.',
        ],
        'not_received' => [
            'message' => 'Si no has recibido el correo,',
        ],
        'request_another' => [
            'label' => 'haz clic aquí para solicitar otro',
        ],
    ],
];
