<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '导出',
        'group' => '导出',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => '导出',
    'plural_label' => '导出',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => '任务ID',
        ],
        'exportable_type' => [
            'label' => '可导出类型',
        ],
        'file_path' => [
            'label' => '文件路径',
        ],
        'format' => [
            'label' => '格式',
        ],
        'status' => [
            'label' => '状态',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
        'completed_at' => [
            'label' => '完成时间',
        ],
    ],
    'actions' => [
        'export' => [
            'label' => '导出',
        ],
        'download' => [
            'label' => '下载',
        ],
    ],
];
