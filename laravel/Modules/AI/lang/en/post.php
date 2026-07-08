<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Posts',
        'plural' => 'Posts',
        'group' => [
            'name' => 'Content',
        ],
    ],
    'fields' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
        'permissions' => 'Permissions',
        'roles' => 'Roles',
        'updated_at' => 'Updated on',
        'first_name' => 'First Name',
        'last_name' => 'Last name',
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Areas al',
            'columns' => [
                'name' => 'Area name',
                'parent_name' => 'Top level area name',
            ],
        ],
    ],
];
