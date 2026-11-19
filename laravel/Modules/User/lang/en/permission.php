<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Permission',
        'plural' => 'Permissions',
        'label' => 'Permissions',
        'group' => 'Access management',
        'icon' => 'heroicon-o-key',
        'sort' => 32,
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter permission name',
            'help' => 'Unique permission name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'placeholder' => 'Enter guard name',
            'help' => 'Guard name for the permission',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => 'Active',
            'placeholder' => 'Select status',
            'help' => 'Indicates if the permission is active',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created At',
            'placeholder' => 'Creation date',
            'help' => 'Permission creation date',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'common' => [
        'yes' => 'Yes',
        'no' => 'No',
    ],
];
