<?php

declare(strict_types=1);

return [
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Display Name',
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
        'created_at' => [
            'label' => 'Created At',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'heroicon-o-clock',
        'group' => 'System',
        'label' => 'Jobs Waiting',
    ],
];
