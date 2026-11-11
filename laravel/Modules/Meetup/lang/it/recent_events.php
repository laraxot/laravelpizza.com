<?php

declare(strict_types=1);

return [
    'fields' => [
        'attendees_count' => [
            'label' => 'Iscritti / posti',
        ],
        'location' => [
            'label' => 'Dove',
        ],
        'title' => [
            'label' => 'Titolo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'start_date' => [
            'label' => 'Inizio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Pubblicazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'organizer' => [
            'name' => [
                'label' => 'Organizzatore',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
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
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
    ],
    'plural_label' => 'Recent Events (Plurale)',
    'navigation' => [
        'name' => 'Recent Events',
        'plural' => 'Recent Events',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Recent Events',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Prossimi eventi e iscritti',
    'empty' => 'Nessun evento in programma',
];
