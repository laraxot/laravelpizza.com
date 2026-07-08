<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique identifier of the snapshot',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_uuid' => [
            'label' => 'Aggregate UUID',
            'tooltip' => 'Unique identifier of the aggregate',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_version' => [
            'label' => 'Aggregate Version',
            'tooltip' => 'Version number of the aggregate',
            'helper_text' => '',
            'description' => '',
        ],
        'state' => [
            'label' => 'State',
            'tooltip' => 'Current state of the snapshot',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => 'Date and time when the snapshot was created',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'View',
            'tooltip' => 'View snapshot details',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete this snapshot',
            'confirmation' => 'Are you sure you want to delete this snapshot?',
        ],
    ],
    'filters' => [
        'date' => [
            'label' => 'Date',
            'tooltip' => 'Filter by creation date',
        ],
        'state' => [
            'label' => 'State',
            'tooltip' => 'Filter by state',
        ],
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
];
