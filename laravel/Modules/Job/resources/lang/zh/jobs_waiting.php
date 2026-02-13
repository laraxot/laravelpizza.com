<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '待处理任务',
        'group' => '任务',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => '待处理任务',
    'plural_label' => '待处理任务',
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
        'attempts' => [
            'label' => '尝试次数',
        ],
        'reserved_at' => [
            'label' => '保留时间',
        ],
        'available_at' => [
            'label' => '可用时间',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => '处理',
        ],
        'retry' => [
            'label' => '重试',
        ],
    ],
];
