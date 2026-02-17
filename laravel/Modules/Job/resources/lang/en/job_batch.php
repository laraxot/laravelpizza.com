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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Total Jobs',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Pending Jobs',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Failed Jobs',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'Failed Job IDs',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Options',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'finished_at' => [
            'label' => 'Finished At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
