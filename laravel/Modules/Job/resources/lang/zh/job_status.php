<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '任务状态',
        'group' => '任务',
        'icon' => 'heroicon-o-status-online',
        'sort' => 45,
    ],
    'label' => '任务状态',
    'plural_label' => '任务状态',
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
        'description' => [
            'label' => '描述',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => '颜色',
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
        'update_status' => [
            'label' => '更新状态',
        ],
        'assign_to_job' => [
            'label' => '分配给任务',
        ],
    ],
];
