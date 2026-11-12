<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => '¡Bienvenido de nuevo a Laravel Pizza Meetups! 🍕',
        'subtitle' => 'Inicia sesión para apuntarte a los meetups y gestionar tus reservas.',
        'page_title' => 'Iniciar sesión',
    ],
    'logout' => [
        'in_progress' => 'Cerrando sesión…',
    ],
    'password' => [
        'request' => [
            'title' => '¿Olvidaste tu contraseña?',
            'subtitle' => 'Escribe el email de tu cuenta y te enviaremos un enlace para elegir una nueva.',
            'email' => 'Email',
            'submit' => 'Enviar el enlace',
            'back_to_login' => 'Volver a iniciar sesión',
        ],
        'reset' => [
            'title' => 'Elige una nueva contraseña',
            'subtitle' => 'Al menos 8 caracteres. Al guardarla entrarás directamente.',
            'email' => 'Email',
            'password' => 'Nueva contraseña',
            'password_confirmation' => 'Repite la nueva contraseña',
            'submit' => 'Guardar contraseña',
        ],
        'confirm' => [
            'title' => 'Confirma tu contraseña',
            'subtitle' => 'Zona protegida: vuelve a escribir tu contraseña para continuar.',
            'password' => 'Contraseña',
            'submit' => 'Confirmar',
            'forgot' => '¿Olvidaste tu contraseña?',
        ],
    ],
    'verify' => [
        'title' => 'Revisa tu email',
        'subtitle' => 'Te hemos enviado un enlace para confirmar tu dirección de email.',
        'resent' => 'Te hemos enviado un nuevo enlace de confirmación.',
        'resend' => '¿No ha llegado? Enviar otro',
        'logout' => 'Cerrar sesión',
    ],
];
