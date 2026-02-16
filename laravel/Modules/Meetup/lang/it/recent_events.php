<?php

declare(strict_types=1);

return [
  'fields' => [
    'title' => [
      'label' => 'title',
    ],
    'start_date' => [
      'label' => 'start_date',
    ],
    'status' => [
      'label' => 'status',
    ],
    'organizer' => [
      'name' => [
        'label' => 'organizer.name',
      ],
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
