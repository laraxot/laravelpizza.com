<?php

declare(strict_types=1);

return [
    'logout_in_progress' => 'Cerrando sesión…',
    'password_reset_page' => [
        'title' => 'Restablecer la contraseña',
        'intro' => 'Introduce tu correo electrónico y te enviaremos un enlace para elegir una nueva contraseña.',
        'email_label' => 'Correo electrónico',
        'submit' => 'Enviar enlace de restablecimiento',
        'return_to_login' => 'Volver al inicio de sesión',
    ],
    'fields' => [
        'email' => [
            'label' => 'Correo electrónico',
            'placeholder' => 'Introduce tu correo electrónico',
            'help' => 'Introduce el correo de tu cuenta',
            'description' => '',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Contraseña',
            'placeholder' => 'Introduce tu contraseña',
            'help' => 'Introduce la contraseña de tu cuenta',
            'description' => '',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'remember' => [
            'label' => 'Recordarme',
            'placeholder' => '',
            'help' => 'Mantener la sesión iniciada en este dispositivo',
            'description' => '',
            'helper_text' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Acceder',
            'success' => 'Sesión iniciada correctamente',
            'error' => 'Las credenciales no son válidas',
            'throttle' => 'Demasiados intentos de acceso. Vuelva a intentarlo en :seconds segundos.',
        ],
        'register' => [
            'label' => 'Crear una cuenta',
            'success' => 'Registro completado',
            'error' => 'No se pudo completar el registro',
        ],
        'forgot_password' => [
            'label' => '¿Has olvidado la contraseña?',
            'success' => 'Hemos enviado las instrucciones',
            'error' => 'No se pudieron enviar las instrucciones',
        ],
        'reset_password' => [
            'label' => 'Restablecer contraseña',
            'success' => 'Contraseña restablecida',
            'error' => 'No se pudo restablecer la contraseña',
        ],
    ],
    'no_account' => '¿Todavía no tienes una cuenta?',
    'register_now' => 'Crear una cuenta',
    'forgot_password_text' => '¿Has olvidado la contraseña?',
    'reset_it' => 'Restablecerla',
    'create_account' => 'Crear una cuenta',
    'messages' => [
        'logout_success' => 'Sesión cerrada correctamente',
        'logout_error' => 'Se produjo un error al cerrar la sesión',
        'user_not_allowed' => 'Tu correo no está autorizado',
        'registration_not_enabled' => 'El registro de usuarios no está disponible',
        'throttle' => 'Demasiados intentos. Inténtalo de nuevo en :seconds segundos.',
        'general_error' => 'Se produjo un error. Inténtalo de nuevo más tarde.',
        'unauthorized' => 'No tienes permisos para realizar esta operación.',
    ],
    'page' => [
        'title' => 'Accede a FixCity',
        'subtitle' => 'Entra para informar de un problema y seguir tus trámites',
    ],
    'already_registered' => '¿Todavía no tienes una cuenta?',
    'register' => 'Regístrate ahora',
];
