<?php

declare(strict_types=1);

return [
    'actions' => [
        'attach_user' => 'Attach User',
        'associate_user' => 'Associate User',
        'user_actions' => 'User Actions',
        'view' => 'View',
        'edit' => 'Edit',
        'detach' => 'Detach',
        'row_actions' => 'Actions',
        'delete_selected' => 'Delete Selected',
        'confirm_detach' => 'Are you sure you want to detach this user?',
        'confirm_delete' => 'Are you sure you want to delete the selected users?',
        'success_attached' => 'User successfully attached',
        'success_detached' => 'User successfully detached',
        'success_deleted' => 'Users successfully deleted',
        'toggle_layout' => 'Toggle Layout',
        'create' => 'Create User',
        'delete' => 'Delete User',
        'associate' => 'Associate User',
        'bulk_delete' => 'Delete Selected',
        'bulk_detach' => 'Detach Selected',
    ],
    'fields' => [
        'name' => 'Name',
        'email' => 'Email',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
        'role' => 'Role',
        'active' => 'Active',
        'id' => 'ID',
        'password' => 'Password',
        'password_confirmation' => 'Confirm Password',
        'email_verified_at' => 'Email Verified At',
    ],
    'filters' => [
        'active_users' => 'Active Users',
        'creation_date' => 'Creation Date',
        'date_from' => 'From',
        'date_to' => 'To',
        'verified' => 'Verified Users',
        'unverified' => 'Unverified Users',
    ],
    'messages' => [
        'no_records' => 'No users found',
        'loading' => 'Loading users...',
        'search' => 'Search users...',
    ],
    'modals' => [
        'create' => [
            'heading' => 'Create User',
            'description' => 'Create a new user record',
            'actions' => [
                'submit' => 'Create',
                'cancel' => 'Cancel',
            ],
        ],
        'edit' => [
            'heading' => 'Edit User',
            'description' => 'Modify user information',
            'actions' => [
                'submit' => 'Save Changes',
                'cancel' => 'Cancel',
            ],
        ],
        'delete' => [
            'heading' => 'Delete User',
            'description' => 'Are you sure you want to delete this user?',
            'actions' => [
                'submit' => 'Delete',
                'cancel' => 'Cancel',
            ],
        ],
        'associate' => [
            'heading' => 'Associate User',
            'description' => 'Select a user to associate',
            'actions' => [
                'submit' => 'Associate',
                'cancel' => 'Cancel',
            ],
        ],
        'detach' => [
            'heading' => 'Detach User',
            'description' => 'Are you sure you want to detach this user?',
            'actions' => [
                'submit' => 'Detach',
                'cancel' => 'Cancel',
            ],
        ],
        'bulk_delete' => [
            'heading' => 'Delete Selected Users',
            'description' => 'Are you sure you want to delete the selected users?',
            'actions' => [
                'submit' => 'Delete Selected',
                'cancel' => 'Cancel',
            ],
        ],
        'bulk_detach' => [
            'heading' => 'Detach Selected Users',
            'description' => 'Are you sure you want to detach the selected users?',
            'actions' => [
                'submit' => 'Detach Selected',
                'cancel' => 'Cancel',
            ],
        ],
    ],
];
