<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Job Monitor',
        'group' => 'Jobs',
        'icon' => 'heroicon-o-chart-bar',
        'sort' => 44,
    ],
    'label' => 'Job Monitor',
    'plural_label' => 'Job Monitors',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Job',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'progress' => [
            'label' => 'Progress',
        ],
        'start_time' => [
            'label' => 'Start Time',
        ],
        'end_time' => [
            'label' => 'End Time',
        ],
        'estimated_completion' => [
            'label' => 'Estimated Completion',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
    ],
    'actions' => [
        'view_progress' => [
            'label' => 'View Progress',
        ],
        'cancel_job' => [
            'label' => 'Cancel Job',
        ],
    ],
];