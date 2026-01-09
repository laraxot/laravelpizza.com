<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Create',
        ],
        'logout' => [
            'tooltip' => 'Logout',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'label' => 'Logout',
        ],
        'cancel' => [
            'tooltip' => 'Cancel',
        ],
        'reorderRecords' => [
            'tooltip' => 'Reorder records',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Edit',
        ],
        'payload' => [
            'label' => 'Payload',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        'attempts' => [
            'label' => 'Attempts',
        ],
        'reserved_at' => [
            'label' => 'Reserved At',
        ],
        'available_at' => [
            'label' => 'Available At',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
    ],
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-cog',
        'group' => 'Jobs',
        'label' => 'Job',
    ],
    'label' => 'Job',
    'plural_label' => 'Jobs',
];