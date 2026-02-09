<?php

declare(strict_types=1);

return [
    // === SECTIONS ===
    'sections' => [
        'user_info' => 'Información Personal',
        'user_info_description' => 'Introduce tus datos personales para crear tu cuenta',
        'required_consents' => 'Consentimiento Obligatorio',
        'required_consents_description' => 'Para proceder con el registro, debes aceptar las siguientes condiciones para el tratamiento de tus datos personales',
        'optional_consents' => 'Consentimiento Opcional',
        'optional_consents_description' => 'Estos consentimientos son opcionales y no afectan tu registro. Puedes modificarlos en cualquier momento desde tu panel de privacidad.',
    ],

    // === FIELDS ===
    'fields' => [
        'first_name' => 'Nombre',
        'last_name' => 'Apellidos',
        'email' => 'Correo Electrónico',
        'password' => 'Contraseña',
        'password_confirmation' => 'Confirmar Contraseña',
    ],

    // === CONSENTS ===
    'consents' => [
        'privacy_policy_label' => 'He leído y comprendido la Política de Privacidad y acepto el tratamiento de mis datos personales como se describe en la política.',
        'privacy_policy_hint' => 'Información completa según los Art. 13 y 14 del Reglamento (UE) 2016/679 (GDPR)',
        'privacy_policy_required' => 'Debes aceptar la política de privacidad para proceder con el registro.',
        
        'terms_label' => 'He leído y acepto los Términos y Condiciones de Uso',
        'terms_hint' => 'Contrato de servicio según el Art. 6(1)(b) del Reglamento (UE) 2016/679 (GDPR)',
        'terms_required' => 'Debes aceptar los términos y condiciones para proceder con el registro.',
        
        'data_processing_label' => 'Consiento el tratamiento de mis datos personales para la creación y gestión de mi cuenta de usuario',
        'data_processing_hint' => 'Base legal: Ejecución del contrato (Art. 6(1)(b) GDPR)',
        'data_processing_required' => 'Debes aceptar el tratamiento de datos para proceder con el registro.',
        
        'marketing_label' => 'Consiento recibir comunicaciones de marketing y promocionales sobre eventos meetup y nuevas funciones',
        'marketing_hint' => 'El consentimiento es opcional y puedes revocarlo en cualquier momento sin consecuencias.',
        
        'profiling_label' => 'Consiento el análisis de mis preferencias para personalizar la experiencia de usuario',
        'profiling_hint' => 'Análisis basado en datos de navegación e interacciones para mejorar nuestros servicios.',
        
        'analytics_label' => 'Consiento el análisis estadístico anónimo de datos de navegación para mejorar el rendimiento del sitio',
        'analytics_hint' => 'Datos recopilados de forma anónima y agregada para fines estadísticos.',
        
        'third_party_label' => 'Consiento compartir mis datos con partners seleccionados para servicios integrados',
        'third_party_hint' => 'Solo partners conformes a GDPR para fines específicos y limitados.',
    ],

    // === VALIDATION ===
    'validation' => [
        'password_complexity' => 'La contraseña debe contener al menos 12 caracteres, una letra mayúscula, una minúscula, un número y un carácter especial.',
    ],

    // === MESSAGES ===
    'required_consent_missing' => 'Debes aceptar todos los consentimientos obligatorios para proceder con el registro.',
    
    'success' => '¡Registro completado con éxito! Tu cuenta ha sido creada en cumplimiento con GDPR.',
    'success_message' => '¡Bienvenido a LaravelPizza Meetups! Tu registro se ha completado y todos tus consentimientos han sido registrados correctamente.',
    
    'error' => 'Error durante el registro',
    'error_message' => 'Ocurrió un error durante el registro. Por favor intenta más tarde. Si el problema persiste, contacta nuestro soporte.',
];