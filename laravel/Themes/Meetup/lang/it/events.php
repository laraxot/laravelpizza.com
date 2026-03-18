<?php

declare(strict_types=1);

return [
    'status' => [
        'all' => [
            'label' => 'Tutti gli eventi',
            'description' => 'Etichetta filtro: tutti gli eventi',
        ],
        'upcoming' => [
            'label' => 'In arrivo',
            'description' => 'Etichetta: eventi futuri',
        ],
        'past' => [
            'label' => 'Eventi passati',
            'description' => 'Etichetta: eventi conclusi',
        ],
    ],

    'fields' => [
        'about_this_event' => [
            'label' => 'Di cosa tratta questo evento',
            'description' => 'Titolo sezione descrizione evento',
        ],
        'event_details' => [
            'label' => 'Dettagli evento',
            'description' => 'Titolo sezione informazioni evento',
        ],
        'date' => [
            'label' => 'Data',
            'description' => 'Etichetta data evento',
        ],
        'time' => [
            'label' => 'Ora',
            'description' => 'Etichetta ora evento',
        ],
        'location' => [
            'label' => 'Luogo',
            'description' => 'Etichetta luogo evento',
        ],
        'language' => [
            'label' => 'Lingua',
            'description' => 'Etichetta lingua evento',
        ],
        'attendees' => [
            'label' => 'Partecipanti',
            'description' => 'Etichetta partecipanti',
        ],
        'people_joined' => [
            'label' => ':count persone hanno aderito',
            'description' => 'Messaggio numero partecipanti',
        ],
        'available_spots' => [
            'label' => ':count posti disponibili',
            'description' => 'Messaggio posti disponibili',
        ],
        'spots_filled' => [
            'label' => 'posti occupati',
            'description' => 'Etichetta conteggio posti',
        ],
    ],

    'actions' => [
        'back_to_events' => [
            'label' => 'Torna agli eventi',
            'tooltip' => 'Torna alla lista eventi',
            'helper_text' => '',
            'description' => 'Link per tornare alla lista eventi',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'secondary',
        ],
        'register_now' => [
            'label' => 'Iscriviti ora',
            'tooltip' => 'Prenota il tuo posto',
            'helper_text' => '',
            'description' => 'CTA per iscrizione',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'primary',
        ],
        'join_event' => [
            'label' => 'Partecipa a questo evento',
            'tooltip' => 'Iscriviti per partecipare',
            'helper_text' => '',
            'description' => 'CTA per partecipare',
            'icon' => 'heroicon-o-user-plus',
            'color' => 'primary',
        ],
        'book_your_spot' => [
            'label' => 'Prenota il tuo posto!',
            'tooltip' => 'Riserva il tuo posto',
            'helper_text' => '',
            'description' => 'CTA urgenza',
            'icon' => 'heroicon-o-ticket',
            'color' => 'primary',
        ],
        'share_event' => [
            'label' => 'Condividi questo evento',
            'tooltip' => 'Condividi con amici',
            'helper_text' => '',
            'description' => 'Etichetta bottone condivisione',
            'icon' => 'heroicon-o-share',
            'color' => 'secondary',
        ],
    ],

    'messages' => [
        'no_events_found' => [
            'label' => 'Nessun evento trovato',
            'description' => 'Messaggio quando non ci sono eventi',
        ],
        'check_back_later' => [
            'label' => 'Torna a controllare più tardi',
            'description' => 'Invito a riprovare più tardi',
        ],
        'event_fallback_title' => [
            'label' => 'Evento',
            'description' => 'Titolo fallback quando manca il titolo evento',
        ],
        'spots_filling_fast' => [
            'label' => 'I posti stanno finendo!',
            'description' => 'Messaggio urgenza posti limitati',
        ],
        'event_location' => [
            'label' => 'Dove si svolge',
            'description' => 'Titolo sezione location',
        ],
        'map_loading' => [
            'label' => 'Caricamento mappa...',
            'description' => 'Messaggio durante caricamento mappa',
        ],
        'click_to_view' => [
            'label' => 'Apri su Google Maps',
            'description' => 'Istruzione per aprire la mappa',
        ],
    ],
];
