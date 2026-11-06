<?php

declare(strict_types=1);

/*
 * Páginas "¿Olvidaste tu contraseña?" y "Contraseña nueva" del front office (DCP-290).
 * El mensaje `sent` es el mismo para una dirección registrada y para una desconocida: no se pueden adivinar las cuentas.
 */
return [
    'title' => '¿Olvidaste tu contraseña?',
    'intro' => 'Escribe el correo electrónico con el que te registraste. Te enviaremos un enlace para elegir una contraseña nueva.',
    'submit' => 'Enviar el enlace',
    'sent' => 'Si la dirección está registrada, recibirás en breve un correo con un enlace para elegir una contraseña nueva. Revisa también la carpeta de spam.',
    'back_to_login' => 'Volver a iniciar sesión',
    'reset_title' => 'Elige una contraseña nueva',
    'reset_intro' => 'Escribe la contraseña nueva dos veces. Después podrás iniciar sesión con ella.',
    'reset_submit' => 'Guardar la contraseña nueva',
    'reset_done' => 'Tu contraseña ha sido cambiada. Inicia sesión con la contraseña nueva.',
    'invalid_link' => 'El enlace no es válido o ha caducado. Solicita uno nuevo.',
    'request_new' => 'Solicitar un enlace nuevo',
    'sending' => 'Enviando…',
    'saving' => 'Guardando…',
];
