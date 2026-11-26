<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'id',
        ],
        'connection' => [
            'label' => 'connection',
        ],
        'queue' => [
            'label' => 'queue',
        ],
        'failed_at' => [
            'label' => 'failed_at',
        ],
        'uuid' => [
            'label' => 'uuid',
        ],
        'payload' => [
            'label' => 'payload',
        ],
        'exception' => [
            'label' => 'exception',
        ],
    ],
    'actions' => [
        'retry_all' => [
            'label' => 'retry_all',
        ],
        'delete_all' => [
            'label' => 'delete_all',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
    ],
];
