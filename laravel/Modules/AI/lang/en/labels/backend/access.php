<?php

declare(strict_types=1);
// Xot translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Xot/docs/wiki — domain i18n only.
// File: lang/en/labels/backend/access.php
// Split from labels/backend.php

return [
    'alertSetting' => [
        'management' => 'Alert Setting Management',
        'active' => 'Active Alert Setting',
        'create' => 'Create Alert Setting',
        'edit' => 'Edit Alert Setting',
        'view' => 'View Alert Setting',
    ],
    'roles' => [
        'create' => 'Create Role',
        'edit' => 'Edit Role',
        'management' => 'Role Management',
        'table' => [
            'number_of_users' => 'Number of Users',
            'permissions' => 'Permissions',
            'role' => 'Role',
            'sort' => 'Sort',
            'total' => 'role total|roles total',
        ],
    ],
    'users' => [
        'active' => 'Active Users',
        'all_permissions' => 'All Permissions',
        'change_password' => 'Change Password',
        'change_password_for' => 'Change Password for :user',
        'create' => 'Create User',
        'deactivated' => 'Deactivated Users',
        'deleted' => 'Deleted Users',
        'edit' => 'Edit User',
        'management' => 'User Management',
        'no_permissions' => 'No Permissions',
        'no_roles' => 'No Roles to set.',
        'permissions' => 'Permissions',
        'cuisine_list' => 'Cuisine List',
        'dishes' => 'Dishes',
        'table' => [
            'confirmed' => 'Confirmed',
            'created' => 'Created',
            'email' => 'E-mail',
            'id' => 'ID',
            'last_updated' => 'Last Updated',
            'name' => 'Name',
            'no_deactivated' => 'No Deactivated Users',
            'no_deleted' => 'No Deleted Users',
            'roles' => 'Roles',
            'total' => 'user total|users total',
        ],
        'tabs' => [
            'titles' => [
                'overview' => 'Overview',
                'history' => 'History',
            ],
            'content' => [
                'overview' => [
                    'ing_name' => 'Ingredient',
                    'avatar' => 'Avatar',
                    'confirmed' => 'Confirmed',
                    'created_at' => 'Created At',
                    'deleted_at' => 'Deleted At',
                    'email' => 'E-mail',
                    'last_updated' => 'Last Updated',
                    'name' => 'Name',
                    'status' => 'Status',
                    'desc' => 'Description',
                    'code' => 'Code',
                    'symbol' => 'symbol',
                    'rate' => 'Rate',
                    'icon' => 'Icon',
                ],
            ],
        ],
        'view' => 'View User',
    ],
];
