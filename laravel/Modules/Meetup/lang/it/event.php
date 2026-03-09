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
        'title' => [
            'label' => 'title',
            'placeholder' => 'title',
            'helper_text' => 'title',
            'description' => 'title',
        ],
        'description' => [
            'label' => 'description',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'description' => 'description',
        ],
        'start_date' => [
            'label' => 'start_date',
            'placeholder' => 'start_date',
            'helper_text' => 'start_date',
            'description' => 'start_date',
        ],
        'end_date' => [
            'label' => 'end_date',
            'placeholder' => 'end_date',
            'helper_text' => 'end_date',
            'description' => 'end_date',
        ],
        'location' => [
            'label' => 'location',
            'placeholder' => 'location',
            'helper_text' => 'location',
            'description' => 'location',
        ],
        'status' => [
            'label' => 'status',
            'placeholder' => 'status',
            'helper_text' => 'status',
            'description' => 'status',
        ],
        'attendees_count' => [
            'label' => 'attendees_count',
            'placeholder' => 'attendees_count',
            'helper_text' => 'attendees_count',
            'description' => 'attendees_count',
        ],
        'max_attendees' => [
            'label' => 'max_attendees',
            'placeholder' => 'max_attendees',
            'helper_text' => 'max_attendees',
            'description' => 'max_attendees',
        ],
        'cover_image' => [
            'label' => 'cover_image',
            'placeholder' => 'cover_image',
            'helper_text' => 'cover_image',
            'description' => 'cover_image',
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
    'sections' => [
        'Event Details' => [
            'label' => 'Event Details',
            'heading' => 'Event Details',
        ],
    ],
];
