<?php

declare(strict_types=1);

// Users table labels (UsersTable / BaseUsersTable).
return [
    'fields' => [
        'name' => ['label' => 'Full name'],
        'email' => ['label' => 'Email'],
        'first_name' => ['label' => 'First name'],
        'last_name' => ['label' => 'Last name'],
        'is_active' => ['label' => 'Active'],
        'email_verified_at' => ['label' => 'Email verified at'],
        'is_otp' => ['label' => 'Temporary password'],
        'lang' => ['label' => 'Language'],
        'current_team_id' => ['label' => 'Current team'],
        'type' => ['label' => 'Type'],
        'state' => ['label' => 'State'],
        'password_expires_at' => ['label' => 'Password expires at'],
        'id' => ['label' => 'ID'],
        'created_at' => ['label' => 'Created at'],
        'updated_at' => ['label' => 'Updated at'],
    ],
    'actions' => [
        'create' => ['label' => 'New user'],
        'delete' => ['label' => 'Delete'],
        'change_password' => ['label' => 'Change password', 'tooltip' => 'Set a new password'],
        'deactivate' => ['label' => 'Deactivate', 'tooltip' => 'Removes access: the user is deleted (restorable from the trash)'],
        'edit' => ['label' => 'Edit'],
        'view' => ['label' => 'View'],
        'verify_email' => ['label' => 'Mark email as verified'],
        'export' => ['label' => 'Export'],
    ],
];
