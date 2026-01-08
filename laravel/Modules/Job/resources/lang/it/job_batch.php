<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'prune_batches',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'failed_job_ids',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'job batch.navigation',
        'group' => 'job batch.navigation',
        'label' => 'job batch.navigation',
    ],
];
