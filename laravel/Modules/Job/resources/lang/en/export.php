<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Export',
        'group' => 'Exports',
        'icon' => 'heroicon-o-arrow-down-tray',
        'sort' => 25,
    ],
    'label' => 'Export',
    'plural_label' => 'Exports',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Job ID',
        ],
        'exportable_type' => [
            'label' => 'Exportable Type',
        ],
        'file_path' => [
            'label' => 'File Path',
        ],
        'format' => [
            'label' => 'Format',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'completed_at' => [
            'label' => 'Completed At',
        ],
    ],
    'actions' => [
        'export' => [
            'label' => 'Export',
        ],
        'download' => [
            'label' => 'Download',
        ],
    ],
];
