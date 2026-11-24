<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'First name',
            'placeholder' => 'Enter the first name',
            'help' => 'The user\'s first name',
            'validation' => [
                'required' => 'The first name is required',
                'max' => 'The first name may not exceed 255 characters',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Last name',
            'placeholder' => 'Enter the last name',
            'help' => 'The user\'s last name',
            'validation' => [
                'required' => 'The last name is required',
                'max' => 'The last name may not exceed 255 characters',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter the email',
            'help' => 'The user\'s email address',
            'validation' => [
                'required' => 'The email is required',
                'email' => 'Enter a valid email',
                'max' => 'The email may not exceed 255 characters',
                'unique' => 'This email is already registered',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter the password',
            'help' => 'The password must be at least 8 characters',
            'validation' => [
                'required' => 'The password is required',
                'min' => 'The password must be at least 8 characters',
                'max' => 'The password may not exceed 255 characters',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm the password',
            'help' => 'Re-enter the password to confirm',
            'validation' => [
                'required' => 'The password confirmation is required',
                'min' => 'The password must be at least 8 characters',
                'max' => 'The password may not exceed 255 characters',
                'same' => 'The passwords do not match',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'remember_me' => [
            'label' => 'Remember me',
            'help' => 'Keep the session active',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'New User',
            'tooltip' => 'Create a new user',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit the user',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete the user',
        ],
    ],
    'teams' => [
        'personal_team' => [
            'label' => 'Personal Team',
            'help' => 'The user\'s personal team',
        ],
    ],
    'devices' => [
        'fields' => [
            'uuid' => [
                'label' => 'UUID',
                'help' => 'Unique device identifier',
            ],
            'mobile_id' => [
                'label' => 'Mobile ID',
                'help' => 'Mobile device identifier',
            ],
            'languages' => [
                'label' => 'Languages',
                'help' => 'The languages supported by the device',
            ],
            'device_name' => [
                'label' => 'Device Name',
                'help' => 'The device name',
            ],
        ],
    ],
    'permissions' => [
        'fields' => [
            'name' => [
                'label' => 'Name',
                'help' => 'The permission name',
            ],
            'guard_name' => [
                'label' => 'Guard Name',
                'help' => 'The guard name',
            ],
            'active' => [
                'label' => 'Active',
                'help' => 'Whether the permission is active',
            ],
            'created_at' => [
                'label' => 'Creation Date',
                'help' => 'Date the permission was created',
            ],
        ],
    ],
    'widgets' => [
        'recent_logins' => [
            'fields' => [
                'user' => [
                    'label' => 'User',
                    'help' => 'The user who logged in',
                ],
                'login_at' => [
                    'label' => 'Login Date',
                    'help' => 'Date and time of login',
                ],
                'ip_address' => [
                    'label' => 'IP Address',
                    'help' => 'The user\'s IP address',
                ],
                'user_agent' => [
                    'label' => 'User Agent',
                    'help' => 'The user\'s browser',
                ],
            ],
        ],
    ],
];
