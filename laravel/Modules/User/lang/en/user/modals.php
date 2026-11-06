<?php

declare(strict_types=1);

// User translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// claude-audit static: split from user.php for maintainability.
// Canon: Modules/User/docs/wiki — domain i18n only.
// File: lang/en/user/modals.php
return [
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
];
