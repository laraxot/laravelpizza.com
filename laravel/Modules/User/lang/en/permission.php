<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter permission name',
            'help' => 'Unique permission name',
        ],
        'guard_name' => [
            'label' => 'Guard Name',
            'placeholder' => 'Enter guard name',
            'help' => 'Guard name for the permission',
        ],
        'active' => [
            'label' => 'Active',
            'placeholder' => 'Select status',
            'help' => 'Indicates if the permission is active',
        ],
        'created_at' => [
            'label' => 'Created At',
            'placeholder' => 'Creation date',
            'help' => 'Permission creation date',
        ],
    ],
    'common' => [
        'yes' => 'Yes',
        'no' => 'No',
    ],
];
