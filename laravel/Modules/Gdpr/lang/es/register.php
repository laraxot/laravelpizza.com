<?php

declare(strict_types=1);

return [
    // === REGISTER PAGE ===
    'title' => 'Comienza tu viaje Pizza 🍕', // Moved from nested 'register' array
    'subtitle' => 'Únete a nuestra comunidad creciente de amantes de la pizza y desarrolladores. Acceso exclusivo a meetups y tutoriales.', // Moved from nested 'register' array
    'submit' => 'Unirse a la comunidad', // Moved from nested 'register' array
    'submitting' => 'Estamos preparando tu horno...', // Moved from nested 'register' array

    // === STATS ===
    'stats' => [
        'active_developers' => 'Comunidad en Crecimiento',
        'monthly_meetups' => 'Próximos Eventos',
        'community_support' => 'Soporte 24/7',
    ],

    // === FORM ===
    'form' => [
        'cta_title' => 'Crea Tu Cuenta GRATUITA',
        'cta_subtitle' => 'No se requiere tarjeta - ¡100% gratuito para siempre!',
        'terms_notice' => 'Al registrarte aceptas nuestros Términos y Política de Privacidad',
    ],

    // === BENEFITS CTA ===
    'benefits' => [
        'community' => [
            'title' => 'Únete a la Comunidad',
            'description' => 'Conecta con profesionales y entusiastas de Laravel',
            'cta' => 'Acceso gratuito inmediato después del registro',
        ],
        'tutorials' => [
            'title' => 'Tutoriales y Talleres Exclusivos',
            'description' => 'Acceso prioritario a contenidos premium y formación',
            'cta' => 'Acceso exclusivo', // Changed from 'Valor €997/año - Gratuito para miembros'
        ],
        'networking' => [
            'title' => 'Networking y Carrera',
            'description' => 'Oportunidades de colaboración y crecimiento profesional',
            'cta' => 'Contratado por las mejores empresas Laravel',
        ],
    ],
    'social_proof' => 'Únete a la comunidad LaravelPizza',
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
        'trust_badges' => 'Sellos de confianza',
        'registration_form' => 'Formulario de registro',
        'benefits' => 'Beneficios',
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
    'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para continuar.',
    'success' => '¡Registro completado con éxito! Tu cuenta ha sido creada cumpliendo con el GDPR.',
    'success_message' => '¡Bienvenido a LaravelPizza Meetups! Tu registro está completo y todos tus consentimientos han sido registrados correctamente.',
    'error' => 'Error de registro',
    'error_message' => 'Ocurrió un error durante el registro. Por favor inténtalo de nuevo más tarde. Si el problema persiste, contacta nuestro soporte.',

    // === CLICKBAIT & MARKETING ===
    'clickbait' => [
        'active_developers' => 'Desarrolladores Activos',
        'monthly_meetups' => 'Meetups Mensuales',
        'community_support' => 'Soporte de Comunidad',
        'free_access' => 'Acceso GRATUITO inmediato después del registro',
        'worth_free' => 'Acceso exclusivo', // Changed from 'Valor €997/año - GRATUITO para miembros'
        'get_hired' => 'Sé contratado por las mejores empresas de Laravel',
        'join_now' => '¡Únete AHORA antes de que cierre el registro!',
        'create_account' => 'Crea Tu Cuenta GRATUITA',
        'no_card_required' => 'No se requiere tarjeta de crédito - ¡100% GRATUITO para siempre!',
        'by_registering' => 'Al registrarte, aceptas nuestros Términos y Política de Privacidad',
    ],

    // === SEO KEYWORDS ===
    'seo' => [
        'description' => 'Únete a la comunidad LaravelPizza para meetups exclusivos, tutoriales premium y networking. Acceso gratuito a talleres y eventos comunitarios.',
        'laravel_meetup' => 'meetup Laravel',
        'laravel_community' => 'comunidad Laravel',
        'php_developer_community' => 'comunidad desarrolladores PHP',
        'laravel_tutorials' => 'tutoriales Laravel',
        'laravel_workshops' => 'talleres Laravel',
        'laravel_networking' => 'networking Laravel',
        'laravelpizza' => 'LaravelPizza',
    ],
];
