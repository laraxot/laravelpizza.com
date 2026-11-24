<?php

declare(strict_types=1);

return [
    'label' => 'AI Action Proposal',
    'plural_label' => 'AI Action Proposals',
    'navigation_group' => 'AI Assistant',
    'fields' => [
        'section' => [
            'label' => 'Proposal details',
        ],
        'thread' => [
            'label' => 'Thread',
        ],
        'type' => [
            'label' => 'Type',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'preview' => [
            'label' => 'Preview',
        ],
        'error' => [
            'label' => 'Error',
        ],
        'confirmed_at' => [
            'label' => 'Confirmed at',
        ],
        'executed_at' => [
            'label' => 'Executed at',
        ],
    ],
    'statuses' => [
        'pending' => 'Pending',
        'cancelled' => 'Cancelled',
        'confirmed' => 'Confirmed',
        'executed' => 'Executed',
        'failed' => 'Failed',
    ],
    'actions' => [
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
];
