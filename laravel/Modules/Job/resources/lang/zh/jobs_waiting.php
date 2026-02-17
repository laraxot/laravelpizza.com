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
        'attempts' => [
            'label' => '尝试次数',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reserved_at' => [
            'label' => '保留时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'available_at' => [
            'label' => '可用时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => '创建时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
