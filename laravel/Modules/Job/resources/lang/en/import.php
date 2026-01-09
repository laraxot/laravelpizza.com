<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Import',
        'group' => 'Imports',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Import',
    'plural_label' => 'Imports',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'Job ID',
        ],
        'importable_type' => [
            'label' => 'Importable Type',
        ],
        'file_path' => [
            'label' => 'File Path',
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
        'import' => [
            'label' => 'Import',
        ],
        'upload' => [
            'label' => 'Upload',
        ],
        'create' => [
            'label' => 'Create',
        ],
    ],
];
