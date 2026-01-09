<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Job Manager',
        'group' => 'Jobs',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Job Manager',
    'plural_label' => 'Job Managers',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'progress' => [
            'label' => 'Progress',
        ],
        'started_at' => [
            'label' => 'Started At',
        ],
        'last_heartbeat' => [
            'label' => 'Last Heartbeat',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create',
        ],
        'restart' => [
            'label' => 'Restart',
        ],
        'pause' => [
            'label' => 'Pause',
        ],
        'resume' => [
            'label' => 'Resume',
        ],
    ],
];
