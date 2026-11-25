<?php

declare(strict_types=1);

return [
    'resources' => 'Risorse',
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Dashboard',
        'plural' => 'Dashboard',
        'group' => [
            'name' => '',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Updated at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'select_all' => [
            'name' => 'Select All',
            'message' => '',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Area name',
                'parent_name' => 'Parent area name',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
