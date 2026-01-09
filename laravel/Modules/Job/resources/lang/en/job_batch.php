<?php

declare(strict_types=1);

return [
    'actions' => [
        'prune_batches' => [
            'label' => 'Prune Batches',
        ],
    ],
    'fields' => [
        'failed_job_ids' => [
            'label' => 'Failed Job IDs',
        ],
    ],
    'navigation' => [
        'sort' => 85,
        'icon' => 'heroicon-o-queue-list',
        'group' => 'System',
        'label' => 'Job Batches',
    ],
];
