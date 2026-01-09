<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Job Status',
        'group' => 'Jobs',
        'icon' => 'heroicon-o-status-online',
        'sort' => 45,
    ],
    'label' => 'Job Status',
    'plural_label' => 'Job Statuses',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Name',
        ],
        'description' => [
            'label' => 'Description',
        ],
        'color' => [
            'label' => 'Color',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Updated At',
        ],
    ],
    'actions' => [
        'update_status' => [
            'label' => 'Update Status',
        ],
        'assign_to_job' => [
            'label' => 'Assign to Job',
        ],
    ],
];