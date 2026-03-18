<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label' => 'Todos los eventos',
            'description' => 'Etiqueta del filtro: todos los eventos',
        ],
        'upcoming' => [
            'label' => 'Próximos',
            'description' => 'Etiqueta: eventos futuros',
        ],
        'past' => [
            'label' => 'Eventos pasados',
            'description' => 'Etiqueta: eventos anteriores',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label' => 'Acerca de este evento',
            'description' => 'Título de sección para la descripción del evento',
        ],
        'event_details' => [
            'label' => 'Detalles del evento',
            'description' => 'Título de sección para la información del evento',
        ],
        'date' => [
            'label' => 'Fecha',
            'description' => 'Etiqueta para la fecha del evento',
        ],
        'time' => [
            'label' => 'Hora',
            'description' => 'Etiqueta para la hora del evento',
        ],
        'location' => [
            'label' => 'Ubicación',
            'description' => 'Etiqueta para la ubicación del evento',
        ],
        'language' => [
            'label' => 'Idioma',
            'description' => 'Etiqueta para el idioma del evento',
        ],
        'attendees' => [
            'label' => 'Asistentes',
            'description' => 'Etiqueta para asistentes',
        ],
        'people_joined' => [
            'label' => ':count personas se han unido',
            'description' => 'Mensaje: número de asistentes',
        ],
        'available_spots' => [
            'label' => ':count plazas disponibles',
            'description' => 'Mensaje: plazas disponibles',
        ],
        'spots_filled' => [
            'label' => 'plazas ocupadas',
            'description' => 'Etiqueta para plazas ocupadas',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label' => 'Volver a eventos',
            'tooltip' => 'Volver a la lista de eventos',
            'helper_text' => '',
            'description' => 'Enlace para volver a la lista de eventos',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
        ],
        'register_now' => [
            'label' => 'Regístrate ahora',
            'tooltip' => 'Reserva tu plaza',
            'helper_text' => '',
            'description' => 'CTA para registro',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'primary',
        ],
        'join_event' => [
            'label' => 'Únete a este evento',
            'tooltip' => 'Inscríbete para asistir',
            'helper_text' => '',
            'description' => 'CTA para unirse',
            'icon' => 'heroicon-o-user-plus',
            'color' => 'primary',
        ],
        'book_your_spot' => [
            'label' => '¡Reserva tu plaza!',
            'tooltip' => 'Reserva tu lugar',
            'helper_text' => '',
            'description' => 'CTA de urgencia',
            'icon' => 'heroicon-o-ticket',
            'color' => 'primary',
        ],
        'share_event' => [
            'label' => 'Comparte este evento',
            'tooltip' => 'Comparte con amigos',
            'helper_text' => '',
            'description' => 'Etiqueta del botón compartir',
            'icon' => 'heroicon-o-share',
            'color' => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label' => 'No se encontraron eventos',
            'description' => 'Mensaje cuando no hay eventos disponibles',
        ],
        'check_back_later' => [
            'label' => 'Vuelve más tarde',
            'description' => 'Invitación a volver más tarde',
        ],
        'event_fallback_title' => [
            'label' => 'Evento',
            'description' => 'Título alternativo cuando falta el título del evento',
        ],
        'spots_filling_fast' => [
            'label' => '¡Las plazas se están agotando!',
            'description' => 'Mensaje de urgencia por plazas limitadas',
        ],
        'event_location' => [
            'label' => 'Ubicación del evento',
            'description' => 'Título para la sección de ubicación',
        ],
        'map_loading' => [
            'label' => 'Cargando mapa...',
            'description' => 'Mensaje mientras carga el mapa',
        ],
        'click_to_view' => [
            'label' => 'Ver en Google Maps',
            'description' => 'Instrucción para ver la ubicación en el mapa',
        ],
    ],
];
