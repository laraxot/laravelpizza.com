<?php

declare(strict_types=1);

// Etichette del form evento (EventResource/Schemas/EventForm): stessi testi di event.php.
return [
    'sections' => [
        'Event Details' => [
            'label' => 'Dettagli dell\'evento',
            'heading' => 'Dettagli dell\'evento',
        ],
        'Speakers and sponsors' => [
            'label' => 'Relatori e sponsor',
            'heading' => 'Relatori e sponsor',
        ],
    ],
    'fields' => [
        'location_id' => [
            'label' => 'Sede',
            'placeholder' => '',
            'helper_text' => 'Facoltativa: scegli una sede salvata o creane una nuova.',
            'description' => '',
            'tooltip' => '',
        ],
        'performers' => [
            'label' => 'Relatori',
            'placeholder' => '',
            'helper_text' => 'Chi parla all\'evento.',
            'description' => '',
            'tooltip' => '',
        ],
        'sponsors' => [
            'label' => 'Sponsor',
            'placeholder' => '',
            'helper_text' => 'Chi sostiene l\'evento.',
            'description' => '',
            'tooltip' => '',
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
            'options' => [
                'draft' => 'Bozza',
                'published' => 'Pubblicato',
                'cancelled' => 'Annullato',
                'pending' => 'In attesa di approvazione',
            ],
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
    ],
];
