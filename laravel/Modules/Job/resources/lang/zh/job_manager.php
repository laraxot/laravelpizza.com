<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '任务管理器',
        'group' => '任务',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => '任务管理器',
    'plural_label' => '任务管理器',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => '名称',
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
        'status' => [
            'label' => '状态',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_heartbeat' => [
            'label' => '最后心跳',
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
        'updated_at' => [
            'label' => '更新时间',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'restart' => [
            'label' => '重启',
        ],
        'pause' => [
            'label' => '暂停',
        ],
        'resume' => [
            'label' => '恢复',
        ],
    ],
];
