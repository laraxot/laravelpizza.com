<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => '创建',
        ],
        'logout' => [
            'tooltip' => '退出登录',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'label' => '退出登录',
        ],
        'cancel' => [
            'tooltip' => '取消',
        ],
        'reorderRecords' => [
            'tooltip' => '重新排序记录',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => '编辑',
        ],
        'payload' => [
            'label' => '内容',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => '队列',
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
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-cog',
        'group' => '任务',
        'label' => '任务',
    ],
    'label' => '任务',
    'plural_label' => '任务',
];