<?php

declare(strict_types=1);

return [
    'register' => [
        'title' => 'Comienza tu viaje Pizza 🍕',
        'subtitle' => 'Únete a más de 5.000 amantes de la pizza y desarrolladores. Acceso exclusivo a meetups y tutoriales.',
        'submit' => 'Unirse a la comunidad',
        'submitting' => 'Estamos preparando tu horno...',
    ],
    'benefits' => [
        'community' => [
            'title' => '5.000+ Comunidad de Desarrolladores',
            'description' => 'Conecta con profesionales y entusiastas de Laravel',
        ],
        'tutorials' => [
            'title' => 'Tutoriales y Talleres Exclusivos',
            'description' => 'Acceso prioritario a contenidos premium y formación',
        ],
        'networking' => [
            'title' => 'Networking y Carrera',
            'description' => 'Oportunidades de colaboración y crecimiento profesional',
        ],
    ],
    'social_proof' => 'Únete a 5.000+ desarrolladores en todo el mundo',
    'fields' => [
        'first_name' => [
            'label' => 'Nombre',
            'placeholder' => 'Mario',
            'helper_text' => 'Ingresa tu nombre para completar tu perfil',
        ],
        'last_name' => [
            'label' => 'Apellidos',
            'placeholder' => 'Rossi',
            'helper_text' => 'Ingresa tus apellidos para completar tu perfil',
        ],
        'email' => [
            'label' => 'Tu mejor correo electrónico',
            'placeholder' => 'mario.rossi@ejemplo.com',
            'helper_text' => 'Te enviaremos un email de confirmación a esta dirección',
        ],
        'password' => [
            'label' => 'Contraseña segura',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Debe contener al menos 12 caracteres, mayúscula, minúscula, número y símbolo',
        ],
        'password_confirmation' => [
            'label' => 'Confirmar contraseña',
            'placeholder' => '••••••••••••',
            'helper_text' => 'Repite la contraseña para confirmar',
        ],
    ],
    'sections' => [
        'user_info' => 'Información Personal',
        'user_info_description' => 'Ingresa tus datos personales para crear tu cuenta',
        'required_consents' => 'Consentimiento Obligatorio',
        'required_consents_description' => 'Para proceder con el registro, debes aceptar las siguientes condiciones para el tratamiento de tus datos personales',
        'optional_consents' => 'Consentimiento Opcional',
        'optional_consents_description' => 'Estos consentimientos son opcionales y no afectan tu registro. Puedes modificarlos en cualquier momento desde tu perfil.',
    ],
    'consents' => [
        'title' => 'Consentimientos de Privacidad',
        'privacy_policy_label' => 'He leído y entendido la política de privacidad y acepto el procesamiento de mis datos personales como se describe en la política.',
        'privacy_policy_hint' => 'Aviso de privacidad completo conforme a los artículos 13 y 14 del Reglamento (UE) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Por favor acepta la política de privacidad para proceder.',
        'privacy_checkbox_html' => 'He leído la <a href=":privacy_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">política de privacidad</a>',
        'terms_label' => 'He leído y acepto los términos y condiciones',
        'terms_hint' => 'Contrato de servicio conforme al artículo 6(1)(b) del Reglamento (UE) 2016/679 (GDPR)',
        'terms_required' => 'Por favor acepta los términos y condiciones para proceder.',
        'terms_checkbox_html' => 'Acepto los <a href=":terms_url" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-semibold hover:text-primary-700">términos y condiciones</a>',
        'marketing_label' => 'Quiero recibir consejos sobre pizza e invitaciones a meetups (opcional)',
        'marketing_hint' => 'El consentimiento es opcional y puedes revocarlo en cualquier momento sin consecuencias.',
        'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para proceder.',
    ],
    'actions' => [
        'read_privacy_policy' => 'Leer política de privacidad',
        'read_terms' => 'Leer términos y condiciones',
    ],
    'validation' => [
        'password_complexity' => 'La contraseña debe contener al menos 12 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial.',
    ],
    'already_registered' => '¿Ya tienes una cuenta?',
    'login' => 'Iniciar sesión',
    'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para proceder.',
    'success' => '¡Registro completado con éxito! Tu cuenta ha sido creada cumpliendo con el GDPR.',
    'success_message' => '¡Bienvenido a LaravelPizza Meetups! Tu registro está completo y todos tus consentimientos han sido registrados correctamente.',
    'error' => 'Error de registro',
    'error_message' => 'Ocurrió un error durante el registro. Por favor inténtalo de nuevo más tarde. Si el problema persiste, contacta nuestro soporte.',
];