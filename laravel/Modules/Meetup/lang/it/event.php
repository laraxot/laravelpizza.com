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
                'tooltip' => 'Esci',
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
            ],
            'timing' => [
                'label' => 'Quando',
                'upcoming' => 'In arrivo',
                'past' => 'Passati',
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
        'label' => 'Eventi',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'Esci',
            'icon' => 'logout',
            'label' => 'Esci',
        ],
        'delete' => [
            'tooltip' => 'Elimina',
            'label' => 'Elimina',
            'icon' => 'delete',
        ],
        'cancel' => [
            'tooltip' => '',
            'icon' => 'cancel',
            'label' => 'Annulla',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'label' => 'profile',
            'icon' => 'profile',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
            'icon' => 'createAnother',
            'label' => 'createAnother',
        ],
        'save' => [
            'tooltip' => 'Salva',
            'icon' => 'save',
            'label' => 'Salva',
        ],
        'create' => [
            'label' => 'Nuovo',
            'icon' => 'create',
            'tooltip' => 'Nuovo',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'submit' => [
            'tooltip' => 'Invia',
            'icon' => 'submit',
            'label' => 'submit',
        ],
        'createOption' => [
            'tooltip' => 'createOption',
            'icon' => 'createOption',
            'label' => 'createOption',
        ],
    ],
    'fields' => [
        'venue' => [
            'name' => [
                'label' => 'Sede',
            ],
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Es. Laravel 13 e Filament 5: cosa cambia',
            'helper_text' => 'Il nome dell\'evento, come lo vedranno i partecipanti.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Di cosa si parla, a chi è rivolto, cosa portare…',
            'helper_text' => 'Testo libero mostrato nella pagina dell\'evento.',
            'description' => '',
            'tooltip' => '',
        ],
        'start_date' => [
            'label' => 'Inizio',
            'placeholder' => '',
            'helper_text' => 'Data e ora di inizio.',
            'description' => '',
            'tooltip' => '',
        ],
        'end_date' => [
            'label' => 'Fine',
            'placeholder' => '',
            'helper_text' => 'Data e ora di fine.',
            'description' => '',
            'tooltip' => '',
        ],
        'location' => [
            'label' => 'Città o luogo',
            'placeholder' => 'Es. Milano',
            'helper_text' => 'Mostrato nella scheda dell\'evento.',
            'description' => '',
            'tooltip' => '',
        ],
        'status' => [
            'label' => 'Pubblicazione',
            'placeholder' => '',
            'helper_text' => 'Solo gli eventi "Pubblicato" sono visibili sul sito.',
            'description' => '',
            'tooltip' => '',
        ],
        'event_status' => [
            'label' => 'Stato dell\'evento',
            'placeholder' => '',
            'helper_text' => 'Programmato, rinviato, annullato…',
            'description' => '',
            'tooltip' => '',
        ],
        'event_attendance_mode' => [
            'label' => 'Modalità',
            'placeholder' => '',
            'helper_text' => 'In presenza, online o mista.',
            'description' => '',
            'tooltip' => '',
        ],
        'attendees_count' => [
            'label' => 'Iscritti',
            'placeholder' => '',
            'helper_text' => 'Calcolato automaticamente: non si modifica a mano.',
            'description' => '',
            'tooltip' => '',
        ],
        'max_attendees' => [
            'label' => 'Posti disponibili',
            'placeholder' => 'Es. 60',
            'helper_text' => 'Numero massimo di iscritti. Obbligatorio, almeno 1.',
            'description' => '',
            'tooltip' => '',
        ],
        'cover_image' => [
            'label' => 'Immagine di copertina',
            'placeholder' => '',
            'helper_text' => 'Facoltativa: appare in cima alla pagina dell\'evento.',
            'description' => '',
            'tooltip' => '',
        ],
        'in_language' => [
            'label' => 'Lingua',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'values' => [
            'label' => 'values',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => '',
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
    'delete_confirmation' => [
        'with_attendees' => 'Questo evento ha :count iscrizioni attive che verranno perse. Confermi l\'eliminazione?',
        'without_attendees' => 'L\'evento non ha iscrizioni. Confermi l\'eliminazione?',
    ],
    'sections' => [
        'Event Details' => [
            'label' => 'Dettagli dell\'evento',
            'heading' => 'Dettagli dell\'evento',
        ],
    ],
];
