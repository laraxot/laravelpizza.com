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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Connection',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Queue',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Exception',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Failed At',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
