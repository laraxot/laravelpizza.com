<?php

declare(strict_types=1);

return [
    'pages' => 'Pages',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Media',
        'plural' => 'Media',
        'group' => [
            'name' => '',
        ],
    ],
    'fields' => [
        'file' => 'file',
        'file_hint' => 'Upload an attachment',
        'name' => [
            'label' => 'Name',
        ],
        'guard_name' => 'Guard',
        'collection_name' => [
            'label' => 'Collection',
        ],
        'filename' => 'Filename',
        'mime_type' => 'Type',
        'human_readable_size' => [
            'label' => 'Size',
        ],
        'permissions' => 'Permissions',
        'updated_at' => 'Updated at',
        'first_name' => 'First Name',
        'last_name' => 'Last Name',
        'select_all' => [
            'name' => 'Select All',
            'message' => '',
        ],
        'creator' => [
            'name' => 'Creator',
            'full_name' => [
                'label' => 'Creator',
            ],
        ],
        'uploaded_at' => 'Updated at',
        'created_at' => [
            'label' => 'Uploaded at',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Areas at',
            'columns' => [
                'name' => 'Area name',
                'parent_name' => 'Parent area name',
            ],
        ],
    ],
];
