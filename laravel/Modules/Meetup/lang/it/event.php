<?php

declare(strict_types=1);

return [
    'event' => [
        'navigation' => [
            'label' => 'Eventi',
            'group' => 'Meetups',
            'icon' => 'heroicon-o-calendar',
            'sort' => 11,
        ],
        'actions' => [
            'logout' => [
                'tooltip' => 'logout',
            ],
            'seed_events' => [
                'label' => 'Importa Eventi JSON',
                'notification' => [
                    'title' => 'Importazione Completata',
                    'body' => 'Importati :count eventi con successo.',
                ],
            ],
        ],
        'filters' => [
            'status' => [
                'label' => 'Stato',
                'upcoming' => 'In arrivo',
                'completed' => 'Completato',
                'cancelled' => 'Cancellato',
                'draft' => 'Bozza',
            ],
            'event_status' => [
                'label' => 'Stato Evento',
                'confirmed' => 'Confermato',
                'scheduled' => 'Programmato',
                'cancelled' => 'Cancellato',
                'postponed' => 'Rinviato',
            ],
            'attendance_mode' => [
                'label' => 'Modalità',
                'offline' => 'In presenza',
                'online' => 'Online',
                'mixed' => 'Mista',
            ],
            'has_capacity' => [
                'label' => 'Posti disponibili',
                'yes' => 'Con posti',
                'no' => 'Completo',
            ],
        ],
    ],
    'navigation' => [
        'sort' => 49,
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'fields' => [
        'event_status' => [
            'label' => 'event_status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'label' => 'Evento',
    'plural_label' => 'Eventi',
    'about_this_event' => [
        'label' => 'Informazioni sull\'evento',
        'color' => 'blue',
    ],
    'back_to_events' => [
        'label' => 'Torna agli eventi',
    ],
    'event_location' => [
        'label' => 'Luogo dell\'evento',
    ],
    'map_loading' => [
        'label' => 'Caricamento mappa...',
    ],
    'click_to_view' => [
        'label' => 'Clicca per visualizzare sulla mappa',
    ],
    'attendees' => [
        'label' => 'Partecipanti',
    ],
    'people_joined' => [
        'label' => ':count persone si sono già iscritte',
    ],
    'join_event' => [
        'label' => 'Partecipa all\'evento',
    ],
    'available_spots' => [
        'label' => 'Posti disponibili',
    ],
    'book_your_spot' => [
        'label' => 'Prenota il tuo posto',
    ],
    'spots_filling_fast' => [
        'label' => 'I posti si stanno esaurendo velocemente!',
    ],
    'share_event' => [
        'label' => 'Condividi l\'evento',
    ],
    'date' => [
        'label' => 'Data',
    ],
    'time' => [
        'label' => 'Ora',
    ],
    'location' => [
        'label' => 'Luogo',
    ],
];
