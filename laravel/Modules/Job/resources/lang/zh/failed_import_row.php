<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => '导入失败行',
        'group' => '导入行',
        'icon' => 'heroicon-o-exclamation-circle',
        'sort' => 28,
    ],
    'label' => '导入失败行',
    'plural_label' => '导入失败行',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'import_batch_id' => [
            'label' => '导入批次ID',
        ],
        'row_index' => [
            'label' => '行索引',
        ],
        'errors' => [
            'label' => '错误',
        ],
        'data' => [
            'label' => '数据',
        ],
        'created_at' => [
            'label' => '创建时间',
        ],
    ],
    'actions' => [
        'view_errors' => [
            'label' => '查看错误',
        ],
        'fix_row' => [
            'label' => '修复行',
        ],
    ],
];
