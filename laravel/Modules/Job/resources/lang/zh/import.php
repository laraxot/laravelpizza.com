<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '导入',
        'group' => '导入',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => '导入',
    'plural_label' => '导入',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => '任务ID',
        ],
        'importable_type' => [
            'label' => '可导入类型',
        ],
        'file_path' => [
            'label' => '文件路径',
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
        'import' => [
            'label' => '导入',
        ],
        'upload' => [
            'label' => '上传',
        ],
    ],
];