<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'register' => [
        'title' => 'Comienza tu viaje Pizza 🍕',
        'subtitle' => 'Únete a más de 5.000 amantes de la pizza y desarrolladores. Acceso exclusivo a meetups y tutoriales.',
        'submit' => 'Unirse a la comunidad',
        'submitting' => 'Estamos calentando el horno...',
        'already_have_account' => '¿Ya eres miembro?',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Nombre',
        'last_name' => 'Apellidos',
        'email' => 'Tu mejor Email',
        'password' => 'Contraseña segura',
        'password_confirmation' => 'Confirmar Contraseña',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consentimiento Obligatorio',
        'privacy_checkbox_html' => 'He leído la <a href=":privacy_url" target="_blank" class="underline font-bold">Política de Privacidad</a>',
        'privacy_policy_required' => 'Debes aceptar la política de privacidad para proceder.',
        'terms_checkbox_html' => 'Acepto los <a href=":terms_url" target="_blank" class="underline font-bold">Términos y Condiciones</a>',
        'terms_required' => 'Debes aceptar los términos y condiciones para proceder.',
        'marketing_label' => 'Quiero recibir consejos sobre pizza e invitaciones a meetups (opcional)',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La contraseña debe contener al menos 12 caracteres, una letra mayúscula, una minúscula, un número y un carácter especial.',
    ],

    // === MESSAGES ===
    'already_registered' => '¿Ya tienes una cuenta?',
    'login' => 'Inicia sesión ahora',
    'success' => '¡Bienvenido a la familia! 🎉',
    'success_message' => 'Tu cuenta está lista. ¡Empieza a explorar todos los meetups!',
    'error' => '¡Ups! Algo salió mal.',
    'error_message' => 'Inténtalo de nuevo en un momento, estamos solucionando el problema.',

    'login' => 'Iniciar sesión',
    'already_registered' => '¿Ya tienes una cuenta?',
];