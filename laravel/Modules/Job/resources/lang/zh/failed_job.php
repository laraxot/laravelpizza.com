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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => '连接',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => '队列',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => '内容',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => '异常',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => '失败时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
