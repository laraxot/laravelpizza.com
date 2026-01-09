<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Waiting Jobs',
        'group' => 'Jobs',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Waiting Job',
    'plural_label' => 'Waiting Jobs',
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