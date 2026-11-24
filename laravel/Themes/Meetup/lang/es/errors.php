<?php

declare(strict_types=1);

// Pagine di errore (laravel/resources/views/errors/*, Themes/Meetup/resources/views/errors/page.blade.php)
return [
    '403' => [
        'title' => 'Acceso denegado',
        'message' => 'Esta página no está disponible para tu cuenta.',
    ],
    '404' => [
        'title' => 'Página no encontrada',
        'message' => 'La página que buscas no existe o se ha movido.',
    ],
    '419' => [
        'title' => 'Sesión caducada',
        'message' => 'La página ha estado abierta demasiado tiempo. Recárgala e inténtalo de nuevo.',
    ],
    '429' => [
        'title' => 'Demasiadas solicitudes',
        'message' => 'Espera un minuto e inténtalo de nuevo.',
    ],
    '500' => [
        'title' => 'Algo ha ido mal',
        'message' => 'Tenemos un problema técnico. Inténtalo de nuevo en unos minutos.',
    ],
    '503' => [
        'title' => 'Volvemos enseguida',
        'message' => 'Estamos actualizando el sitio. Inténtalo de nuevo en unos minutos.',
    ],
    'label' => 'Error',
    'actions' => [
        'home' => 'Volver al inicio',
        'events' => 'Ver los próximos eventos',
        'reload' => 'Recargar la página',
        'login' => 'Iniciar sesión',
    ],
];
