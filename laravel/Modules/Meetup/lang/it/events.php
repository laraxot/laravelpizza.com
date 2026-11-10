<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Eventi',
        'plural_label' => 'Eventi',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'label' => 'Eventi',
    'plural_label' => 'Eventi',
    'fields' => [
        'title' => [
            'label' => 'Titolo',
        ],
        'start_date' => [
            'label' => 'Inizio',
        ],
        'end_date' => [
            'label' => 'Fine',
        ],
        'location' => [
            'label' => 'Città',
        ],
        'venue' => [
            'name' => [
                'label' => 'Sede',
            ],
        ],
        'status' => [
            'label' => 'Pubblicazione',
        ],
        'event_status' => [
            'label' => 'Stato',
        ],
        'event_attendance_mode' => [
            'label' => 'Modalità',
        ],
        'attendees_count' => [
            'label' => 'Iscritti',
        ],
        'max_attendees' => [
            'label' => 'Posti',
        ],
        'in_language' => [
            'label' => 'Lingua',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'has_capacity' => [
            'label' => 'has_capacity',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo',
            'tooltip' => 'Nuovo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica',
            'icon' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina',
            'icon' => 'delete',
        ],
        'view' => [
            'label' => 'Apri',
            'tooltip' => 'Apri',
        ],
        'layout' => [
            'label' => 'Cambia vista',
            'tooltip' => 'Cambia vista (tabella o schede)',
        ],
    ],
    'no_events_found' => [
        'label' => 'Nessun evento trovato',
        'description' => 'Non ci sono eventi che corrispondono ai criteri di ricerca',
    ],
    'check_back_later' => [
        'label' => 'Torna a trovarci presto',
        'description' => 'Nuovi eventi saranno presto disponibili',
    ],
];
