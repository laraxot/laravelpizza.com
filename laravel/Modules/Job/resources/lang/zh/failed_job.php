<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '失败任务',
        'group' => '失败任务',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => '失败任务',
    'plural_label' => '失败任务',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'connection' => [
            'label' => '连接',
        ],
        'queue' => [
            'label' => '队列',
        ],
        'payload' => [
            'label' => '内容',
        ],
        'exception' => [
            'label' => '异常',
        ],
        'failed_at' => [
            'label' => '失败时间',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => '重试',
        ],
        'delete' => [
            'label' => '删除',
        ],
    ],
];
