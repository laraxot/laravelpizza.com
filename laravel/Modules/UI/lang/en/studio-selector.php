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
            'label' => 'Address not available',
        ],
        'visit_website' => [
            'label' => 'Visit website',
        ],
        'services_offered' => [
            'label' => 'Services offered',
        ],
        'more_services' => [
            'label' => '+:count more',
        ],
        'today_hours' => [
            'label' => 'Today: :open - :close',
        ],
        'today_closed' => [
            'label' => 'Today: Closed',
        ],
        'actions' => [
            'book' => 'Book',
            'details' => 'Details',
            'call' => 'Call',
        ],
    ],
    'list' => [
        'services_count' => [
            'label' => ':count services',
        ],
        'empty' => [
            'title' => 'No studio found',
            'description' => 'There are no studios available in the selected area.',
        ],
        'selected' => [
            'label' => 'Selected studio: :name',
        ],
    ],
    'sections' => [
        'buttons' => [
            'title' => 'The dental studios closest to you',
        ],
    ],
    'buttons' => [
        'empty' => [
            'message' => 'No studio found matching the selected search criteria.',
        ],
    ],
];
