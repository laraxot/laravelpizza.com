<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Eventi',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-calendar',
        'sort' => 11,
    ],
    'label' => 'Evento',
    'plural_label' => 'Eventi',
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo dell\'evento',
            'help' => 'Nome dell\'evento che verrà visualizzato pubblicamente',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Descrivi l\'evento...',
            'help' => 'Descrizione dettagliata dell\'evento',
        ],
        'start_date' => [
            'label' => 'Data inizio',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di inizio dell\'evento',
        ],
        'end_date' => [
            'label' => 'Data fine',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di fine dell\'evento',
        ],
        'location' => [
            'label' => 'Luogo',
            'placeholder' => 'Inserisci il luogo',
            'help' => 'Indirizzo o nome del luogo',
        ],
        'max_attendees' => [
            'label' => 'Partecipanti max',
            'placeholder' => 'Numero massimo',
            'help' => 'Numero massimo di partecipanti',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Evento',
            'modal_heading' => 'Crea nuovo evento',
            'modal_description' => 'Compila i dati per creare un nuovo evento',
            'success' => 'Evento creato con successo',
            'error' => 'Errore durante la creazione dell\'evento',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal_heading' => 'Modifica evento',
            'modal_description' => 'Modifica i dati dell\'evento',
            'success' => 'Evento aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal_heading' => 'Elimina evento',
            'modal_description' => 'Sei sicuro di voler eliminare questo evento?',
            'success' => 'Evento eliminato',
            'error' => 'Errore durante l\'eliminazione',
            'confirmation' => 'Conferma eliminazione',
        ],
        'register' => [
            'label' => 'Prenota posto',
            'modal_heading' => 'Iscriviti all\'evento',
            'modal_description' => 'Conferma la tua iscrizione',
            'success' => 'Iscrizione completata',
            'error' => 'Errore durante l\'iscrizione',
        ],
    ],
    'sections' => [
        'about_this_event' => [
            'label' => 'Informazioni sull\'evento',
            'heading' => 'About This Event',
            'description' => 'Dettagli e informazioni',
            'color' => 'blue',
            'icon' => 'heroicon-o-information-circle',
        ],
        'event_location' => [
            'label' => 'Luogo dell\'evento',
            'heading' => 'Event Location',
            'description' => 'Dove si terrà l\'evento',
            'color' => 'green',
            'icon' => 'heroicon-o-map-pin',
        ],
        'attendees' => [
            'label' => 'Partecipanti',
            'heading' => 'Attendees',
            'description' => 'Chi parteciperà',
            'color' => 'purple',
            'icon' => 'heroicon-o-users',
        ],
        'share_event' => [
            'label' => 'Condividi l\'evento',
            'heading' => 'Share Event',
            'description' => 'Condividi con gli amici',
            'color' => 'orange',
            'icon' => 'heroicon-o-share',
        ],
    ],
    'messages' => [
        'no_events' => [
            'title' => 'Nessun evento',
            'description' => 'Non ci sono eventi programmati al momento',
        ],
        'event_full' => [
            'title' => 'Evento al completo',
            'description' => 'Tutti i posti sono stati prenotati',
        ],
        'registration_closed' => [
            'title' => 'Iscrizioni chiuse',
            'description' => 'Le iscrizioni per questo evento sono chiuse',
        ],
    ],
    'status' => [
        'upcoming' => [
            'label' => 'In arrivo',
            'color' => 'success',
            'badge' => 'Upcoming',
        ],
        'past' => [
            'label' => 'Passato',
            'color' => 'gray',
            'badge' => 'Past Event',
        ],
        'cancelled' => [
            'label' => 'Cancellato',
            'color' => 'danger',
            'badge' => 'Cancelled',
        ],
    ],
    'filters' => [
        'status' => [
            'label' => 'Stato',
            'options' => [
                'all' => 'Tutti',
                'upcoming' => 'In arrivo',
                'past' => 'Passati',
            ],
        ],
    ],
    'widgets' => [
        'stats_overview' => [
            'label' => 'Statistiche Eventi',
            'description' => 'Panoramica degli eventi',
        ],
    ],
];
