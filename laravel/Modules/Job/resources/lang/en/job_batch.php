<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Job Batch',
        'group' => 'Batches',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Job Batch',
    'plural_label' => 'Job Batches',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'total_jobs' => [
            'label' => 'Total Jobs',
        ],
        'pending_jobs' => [
            'label' => 'Pending Jobs',
        ],
        'failed_jobs' => [
            'label' => 'Failed Jobs',
        ],
        'failed_job_ids' => [
            'label' => 'Failed Job IDs',
        ],
        'options' => [
            'label' => 'Options',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'finished_at' => [
            'label' => 'Finished At',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'View Details',
        ],
        'cancel' => [
            'label' => 'Cancel',
        ],
        'prune_batches' => [
            'label' => 'Prune Batches',
        ],
    ],
];
