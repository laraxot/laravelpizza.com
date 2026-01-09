<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Failed Job',
        'group' => 'Failed Jobs',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Failed Job',
    'plural_label' => 'Failed Jobs',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => 'Connection',
        ],
        'queue' => [
            'label' => 'Queue',
        ],
        'payload' => [
            'label' => 'Payload',
        ],
        'exception' => [
            'label' => 'Exception',
        ],
        'failed_at' => [
            'label' => 'Failed At',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Retry',
        ],
        'delete' => [
            'label' => 'Delete',
        ],
        'retry_all' => [
            'label' => 'Retry All',
        ],
        'delete_all' => [
            'label' => 'Delete All',
        ],
    ],
];
