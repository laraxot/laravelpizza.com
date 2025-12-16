<?php

declare(strict_types=1);

return [
    'pages' => 'Pages',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Media',
        'plural' => 'Media',
        'group' => [
            'name' => 'System',
            'description' => 'Multimedia file management',
        ],
        'label' => 'media',
        'sort' => '20',
        'icon' => 'media-main-animated',
    ],
    'fields' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
        'collection_name' => 'Collection',
        'filename' => 'Filename',
        'mime_type' => 'Type',
        'human_readable_size' => 'Size',
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
        ],
        'uploaded_at' => 'Uploaded at',
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
