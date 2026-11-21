<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => ['label' => 'id'],
        'name' => ['label' => 'name'],
        'created_at' => ['label' => 'created_at'],
        'total_jobs' => ['label' => 'total_jobs'],
        'pending_jobs' => ['label' => 'pending_jobs'],
        'failed_jobs' => ['label' => 'failed_jobs'],
        'finished_at' => ['label' => 'finished_at'],
        'cancelled_at' => ['label' => 'cancelled_at'],
    ],
    'actions' => [
        'create' => ['label' => 'create', 'icon' => 'create', 'tooltip' => 'create'],
    ],
];
