<?php

declare(strict_types=1);

// Etichette del form (VenueResource/Schemas/VenueForm, usato anche dal form evento).
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Es. Talent Garden Calabiana',
            'helper_text' => 'Il nome del locale o della sala.',
            'description' => '',
            'tooltip' => '',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Es. Via Arcivescovo Calabiana 6',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Es. Milano',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'capacity' => [
            'label' => 'Capienza',
            'placeholder' => '',
            'helper_text' => 'Quante persone ci stanno al massimo.',
            'description' => '',
            'tooltip' => '',
        ],
        'website' => [
            'label' => 'Sito web',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'placeholder' => '',
            'helper_text' => 'Facoltativa: serve per la mappa.',
            'description' => '',
            'tooltip' => '',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'placeholder' => '',
            'helper_text' => 'Facoltativa: serve per la mappa.',
            'description' => '',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Note',
            'placeholder' => '',
            'helper_text' => 'Come arrivare, a che piano, parcheggi…',
            'description' => '',
            'tooltip' => '',
        ],
        'events_count' => [
            'label' => 'Eventi',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
];
