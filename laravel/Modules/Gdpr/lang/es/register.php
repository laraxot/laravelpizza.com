<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'register' => [
        'title' => 'Comienza tu viaje Pizza 🍕',
        'subtitle' => 'Únete a más de 5.000 amantes de la pizza y desarrolladores. Acceso exclusivo a meetups y tutoriales.',
        'submit' => 'Unirse a la comunidad',
        'submitting' => 'Estamos preparando tu horno...',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => [
            'label' => 'Nombre',
            'placeholder' => 'Juan',
            'helper_text' => 'Tu nombre para la comunidad',
        ],
        'last_name' => [
            'label' => 'Apellidos',
            'placeholder' => 'García',
            'helper_text' => 'Tus apellidos para la comunidad',
        ],
        'email' => [
            'label' => 'Tu mejor correo electrónico',
            'placeholder' => 'juan@ejemplo.es',
            'helper_text' => 'Sin spam, solo contenido Laravel 🚀',
        ],
        'password' => [
            'label' => 'Contraseña segura',
            'placeholder' => 'Algo súper secreto...',
            'helper_text' => 'Mínimo 8 caracteres',
        ],
        'password_confirmation' => [
            'label' => 'Confirmar contraseña',
            'placeholder' => 'Repite tu contraseña',
            'helper_text' => 'Asegúrate de que coincida',
        ],
    ],

    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Información Personal',
        'user_info_description' => 'Introduce tus datos personales para crear tu cuenta',
        'required_consents' => 'Consentimiento Obligatorio',
        'required_consents_description' => 'Para proceder con el registro, debes aceptar las siguientes condiciones para el tratamiento de tus datos personales',
        'optional_consents' => 'Consentimiento Opcional',
        'optional_consents_description' => 'Estos consentimientos son opcionales y no afectan tu registro. Puedes modificarlos en cualquier momento desde tu panel de privacidad.',
    ],

    // === CONSENTS ===
    'consents' => [
        'title' => 'Consentimientos de privacidad',
        'privacy_policy_label' => 'He leído y comprendido la Política de Privacidad y acepto el tratamiento de mis datos personales como se describe en la política.',
        'privacy_policy_hint' => 'Información completa según los Art. 13 y 14 del Reglamento (UE) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Debes aceptar la política de privacidad para proceder con el registro.',
        'privacy_checkbox_html' => 'He leído la <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Política de Privacidad</a>',
        'terms_label' => 'He leído y acepto los Términos y Condiciones de Uso',
        'terms_hint' => 'Contrato de servicio según el Art. 6(1)(b) del Reglamento (UE) 2016/679 (GDPR)',
        'terms_required' => 'Debes aceptar los términos y condiciones para proceder con el registro.',
        'terms_checkbox_html' => 'Acepto los <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">Términos y Condiciones</a>',
        'marketing_label' => 'Quiero recibir consejos sobre la pizza e invitaciones a meetups (opcional)',
        'marketing_hint' => 'El consentimiento es opcional y puedes revocarlo en cualquier momento sin consecuencias.',
        'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para proceder con el registro.',
    ],

    // === ACTIONS ===
    'actions' => [
        'read_privacy_policy' => 'Leer política de privacidad',
        'read_terms' => 'Leer términos y condiciones',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La contraseña debe contener al menos 12 caracteres, una letra mayúscula, una minúscula, un número y un carácter especial.',
    ],

    // === MESSAGES ===
    'already_registered' => '¿Ya tienes una cuenta?',
    'login' => 'Iniciar sesión',
    'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para proceder con el registro.',
    'success' => '¡Registro completado con éxito! Tu cuenta ha sido creada en cumplimiento con GDPR.',
    'success_message' => '¡Bienvenido a LaravelPizza Meetups! Tu registro se ha completado y todos tus consentimientos han sido registrados correctamente.',
    'error' => 'Error durante el registro',
    'error_message' => 'Ocurrió un error durante el registro. Por favor intenta más tarde. Si el problema persiste, contacta nuestro soporte.',
];