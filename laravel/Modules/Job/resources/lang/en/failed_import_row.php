<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Failed Import Row',
        'group' => 'Imports',
        'icon' => 'heroicon-o-exclamation-circle',
        'sort' => 28,
    ],
    'label' => 'Failed Import Row',
    'plural_label' => 'Failed Import Rows',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'import_batch_id' => [
            'label' => 'Import Batch ID',
        ],
        'row_index' => [
            'label' => 'Row Index',
        ],
        'errors' => [
            'label' => 'Errors',
        ],
        'data' => [
            'label' => 'Data',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
    ],
    'actions' => [
        'view_errors' => [
            'label' => 'View Errors',
        ],
        'fix_row' => [
            'label' => 'Fix Row',
        ],
    ],
];
