<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'title',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'start_date' => [
            'label' => 'start_date',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'organizer' => [
            'name' => [
                'label' => 'organizer.name',
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
    ],
    'label' => 'Recent Events',
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
];
