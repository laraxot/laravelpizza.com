<?php

declare(strict_types=1);

return [
    'sections' => [
        'tasks' => [
            'title' => 'Scheduled tasks',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New task',
        ],
        'run_now' => [
            'label' => 'Run now',
        ],
    ],
    'fields' => [
        'description' => [
            'label' => 'Description',
        ],
        'average_runtime' => [
            'label' => 'Average runtime',
        ],
        'last_run' => [
            'label' => 'Last run',
        ],
        'next_run' => [
            'label' => 'Next run',
        ],
    ],
    'messages' => [
        'runtime_seconds' => [
            'message' => ':seconds seconds',
        ],
        'no_tasks' => [
            'message' => 'No tasks found.',
        ],
    ],
];
