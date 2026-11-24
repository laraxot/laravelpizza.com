<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Roles',
        'plural' => 'Roles',
        'group' => [
            'name' => 'User management',
            'description' => 'Roles and their permissions',
        ],
        'label' => 'Roles',
        'sort' => '26',
        'icon' => 'user-role-animated',
    ],
    'fields' => [
        'name' => [
            'label' => 'Role name',
        ],
        'permissions' => [
            'label' => 'Permissions',
            'tooltip' => 'Select the permissions of this role.',
            'placeholder' => 'Select permissions',
            'helper_text' => '',
            'description' => '',
        ],
        'users_count' => [
            'label' => 'Users',
            'tooltip' => 'How many users have this role.',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => 'When the role was created.',
            'placeholder' => 'Creation date',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last updated',
            'tooltip' => 'When the role was last changed.',
            'placeholder' => 'Last updated',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => 'What the role is for.',
            'placeholder' => 'Role description',
        ],
    ],
    'roles' => [
        'super_admin' => 'Super administrator',
        'admin' => 'Administrator',
        'manager' => 'Manager',
        'editor' => 'Editor',
        'user' => 'User',
    ],
    'actions' => [
        'create' => [
            'label' => 'New role',
            'tooltip' => 'Create a new role.',
            'icon' => 'fa fa-plus',
            'color' => 'success',
        ],
        'edit' => [
            'label' => 'Edit role',
            'tooltip' => 'Edit the selected role.',
            'icon' => 'fa fa-edit',
            'color' => 'primary',
        ],
        'delete' => [
            'label' => 'Delete role',
            'tooltip' => 'Delete this role.',
            'icon' => 'fa fa-trash',
            'color' => 'danger',
        ],
        'assign_permissions' => [
            'label' => 'Assign permissions',
            'tooltip' => 'Assign permissions to the role.',
            'icon' => 'fa fa-check',
            'color' => 'info',
        ],
        'sync_permissions' => [
            'label' => 'Sync permissions',
            'tooltip' => 'Sync the permissions with another system.',
            'icon' => 'fa fa-sync',
            'color' => 'warning',
        ],
    ],
    'messages' => [
        'created' => 'Role created',
        'updated' => 'Role updated',
        'deleted' => 'Role deleted',
        'permissions_updated' => 'Permissions updated',
        'cannot_delete_super_admin' => 'You cannot delete the super administrator role',
        'role_in_use' => 'You cannot delete a role that is assigned to users',
    ],
    'descriptions' => [
        'super_admin' => 'Full access to every feature.',
        'admin' => 'Access to most administrative features.',
        'manager' => 'Manages specific users and content.',
        'editor' => 'Edits and manages content.',
        'user' => 'Basic access.',
    ],
    'permissions_groups' => [
        'users' => 'User management',
        'roles' => 'Role management',
        'content' => 'Content management',
        'settings' => 'Settings',
        'reports' => 'Report',
    ],
    // Display names of the role codes (spatie role `name`). The code stays the stored value.
    'labels' => [
        'super-admin' => 'Super admin',
        'restaurant__admin' => 'Owner',
        'restaurant__restaurateur' => 'Restaurateur',
        'admin' => 'Administrator',
        'moderator' => 'Moderator',
        'editor' => 'Editor',
        'manager' => 'Manager',
        'user' => 'User',
        'guest' => 'Guest',
        'bar' => 'Bar',
        'kitchen' => 'Kitchen',
        'cashier' => 'Cashier',
        'waiter' => 'Waiter',
        'respHACCP' => 'HACCP manager',
    ],
    'label' => 'Role',
    'plural_label' => 'Roles',
];
