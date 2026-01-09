<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Jobs Waiting',
        'group' => 'Jobs',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Job Waiting',
    'plural_label' => 'Jobs Waiting',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => 'Connection',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        'payload' => [
            'label' => 'Payload',
        ],
        'attempts' => [
            'label' => 'Attempts',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Display Name',
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
    'actions' => [
        'process' => [
            'label' => 'Process',
        ],
        'retry' => [
            'label' => 'Retry',
        ],
    ],
];
