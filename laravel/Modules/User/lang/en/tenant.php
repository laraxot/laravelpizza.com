<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'plural' => 'Tenants',
        'group' => [
            'name' => 'User management',
            'description' => 'Manage tenants and their settings',
        ],
        'label' => 'Tenant',
        'sort' => '30',
        'icon' => 'user-user-tenant',
    ],
    'table' => [
        'heading' => 'Tenant',
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'secondary_color' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'message' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
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
            'filename_prefix' => 'Areas as of',
            'columns' => [
                'name' => 'Area name',
                'parent_name' => 'Parent area name',
            ],
        ],
        'change_password' => 'Change password',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
