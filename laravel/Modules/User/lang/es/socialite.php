<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => 'Guardar configuración',
    ],
    'help' => [
        'title' => 'Guía de configuración',
        'description' => 'Configura las credenciales OAuth de los proveedores para que los usuarios puedan iniciar sesión con sus cuentas sociales.',
        'google_title' => 'Google OAuth',
        'google_step1' => 'Ve a la <a href=":url" target="_blank" rel="noopener" class="underline">Google Cloud Console</a> y crea un proyecto (o selecciona uno existente).',
        'google_step2' => 'Habilita las API necesarias y configura la pantalla de consentimiento de OAuth.',
        'google_step3' => 'Crea credenciales de tipo «ID de cliente de OAuth» para una aplicación web.',
        'google_step4' => 'Copia el ID de cliente y el secreto de cliente y pégalos en el formulario de arriba.',
        'redirect_url_note' => 'URL de redirección',
        'redirect_url_description' => 'Establece la URL de callback que se muestra en el formulario como URI de redirección autorizado.',
    ],
    'security' => [
        'title' => 'Aviso de seguridad',
        'description' => 'Las credenciales se guardan de forma segura. No las compartas ni las incluyas nunca en repositorios públicos.',
    ],
];
