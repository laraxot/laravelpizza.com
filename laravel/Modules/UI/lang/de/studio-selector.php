<?php

declare(strict_types=1);

return [
    'actions' => [
        'select' => [
            'label' => 'Seleziona',
            'description' => 'Scegli questo studio',
        ],
    ],
    'empty' => [
        'title' => 'Nessuno studio trovato',
        'description' => 'Non ci sono studi disponibili per la zona selezionata.',
    ],
    'fields' => [
        'distance' => [
            'label' => 'Distanza',
            'helper_text' => 'Distanza approssimativa dalla tua posizione',
            'tooltip' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Telefono',
            'helper_text' => 'Numero di telefono dello studio',
            'tooltip' => '',
            'description' => '',
        ],
        'specializations' => [
            'label' => 'Specializzazioni',
            'helper_text' => 'Servizi offerti dallo studio',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'accessibility' => [
        'studio_card' => 'Scheda studio, clicca per selezionare',
        'selected_studio' => 'Studio selezionato',
        'select_studio' => 'Premi spazio o invio per selezionare questo studio',
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'card' => [
        'address_unavailable' => [
            'label' => 'Adresse nicht verfügbar',
        ],
        'visit_website' => [
            'label' => 'Website besuchen',
        ],
        'services_offered' => [
            'label' => 'Angebotene Leistungen',
        ],
        'more_services' => [
            'label' => '+:count weitere',
        ],
        'today_hours' => [
            'label' => 'Heute: :open - :close',
        ],
        'today_closed' => [
            'label' => 'Heute: Geschlossen',
        ],
        'actions' => [
            'book' => 'Buchen',
            'details' => 'Details',
            'call' => 'Anrufen',
        ],
    ],
    'list' => [
        'services_count' => [
            'label' => ':count Leistungen',
        ],
        'empty' => [
            'title' => 'Keine Praxis gefunden',
            'description' => 'Im ausgewählten Gebiet sind keine Praxen verfügbar.',
        ],
        'selected' => [
            'label' => 'Ausgewählte Praxis: :name',
        ],
    ],
    'sections' => [
        'buttons' => [
            'title' => 'Die Zahnarztpraxen in Ihrer Nähe',
        ],
    ],
    'buttons' => [
        'empty' => [
            'message' => 'Keine Praxis gefunden, die den ausgewählten Suchkriterien entspricht.',
        ],
    ],
];
