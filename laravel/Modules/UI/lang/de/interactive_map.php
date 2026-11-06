<?php

declare(strict_types=1);

return [
    'actions' => [
        'clear_filters' => [
            'label' => 'Filter zurücksetzen',
        ],
        'export_csv' => [
            'label' => 'CSV exportieren',
        ],
        'export_json' => [
            'label' => 'JSON exportieren',
        ],
        'reset_view' => [
            'label' => 'Ansicht zurücksetzen',
        ],
    ],
    'sections' => [
        'actions' => [
            'title' => 'Aktionen',
        ],
        'search' => [
            'title' => 'Suche',
        ],
        'stats' => [
            'title' => 'Statistiken',
        ],
    ],
    'filters' => [
        'locations' => [
            'label' => 'Orte',
        ],
        'ticket_status' => [
            'label' => 'Ticket-Status',
        ],
        'tickets' => [
            'label' => 'Tickets',
        ],
        'type' => [
            'label' => 'Typ',
        ],
        'users' => [
            'label' => 'Benutzer',
        ],
    ],
    'fields' => [
        'loading' => [
            'label' => 'Wird geladen...',
        ],
        'search' => [
            'placeholder' => 'Adresse suchen...',
        ],
    ],
    'loading' => [
        'markers' => [
            'label' => 'Marker werden geladen...',
        ],
    ],
    'marker' => [
        'select' => [
            'label' => 'Auswählen',
        ],
        'unknown_user' => [
            'message' => 'Unbekannt',
        ],
        'view' => [
            'label' => 'Anzeigen',
        ],
    ],
    'stats' => [
        'filtered' => [
            'label' => 'Gefiltert',
        ],
        'total_markers' => [
            'label' => 'Marker insgesamt',
        ],
        'visible' => [
            'label' => 'Sichtbar',
        ],
    ],
    'status' => [
        'assigned' => [
            'label' => 'Zugewiesen',
        ],
        'in_progress' => [
            'label' => 'In Bearbeitung',
        ],
        'pending' => [
            'label' => 'Ausstehend',
        ],
        'resolved' => [
            'label' => 'Gelöst',
        ],
    ],
];
