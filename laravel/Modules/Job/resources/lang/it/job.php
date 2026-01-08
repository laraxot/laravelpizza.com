<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'create',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'edit',
        ],
        'payload' => [
            'label' => 'payload',
        ],
        'id' => [
            'label' => 'id',
        ],
        'queue' => [
            'label' => 'queue',
        ],
        'attempts' => [
            'label' => 'attempts',
        ],
        'reserved_at' => [
            'label' => 'reserved_at',
        ],
        'available_at' => [
            'label' => 'available_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
    ],
    'navigation' => [
        'sort' => 58,
        'icon' => 'job.navigation',
        'group' => 'job.navigation',
        'label' => 'job.navigation',
    ],
    'label' => 'job',
];
