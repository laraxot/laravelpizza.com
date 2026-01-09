<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Create',
        ],
    ],
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        'progress' => [
            'label' => 'Progress',
        ],
        'started_at' => [
            'label' => 'Started At',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'System',
        'label' => 'Job Manager',
    ],
];
