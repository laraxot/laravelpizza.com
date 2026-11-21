<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Password',
        'plural' => 'Passwords',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'password' => [
            'label' => 'Password',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
        ],
        'first_name' => [
            'label' => 'First name',
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
        'otp_expiration_minutes' => [
            'help' => 'Validity of the temporary password, in minutes',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'otp_length' => [
            'help' => 'OTP code length',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_in' => [
            'help' => 'Number of days before the password expires',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'min' => [
            'help' => 'Minimum password length',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'mixedCase' => [
            'help' => 'The password requires at least one uppercase and one lowercase letter',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'letters' => [
            'help' => 'The password requires at least one letter',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'numbers' => [
            'help' => 'The password requires at least one number',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'symbols' => [
            'help' => 'The password requires at least one symbol',
            'label' => [
                'help' => 'The password requires at least one symbol',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'uncompromised' => [
            'help' => 'Whether the password must not have been compromised in data leaks',
            'label' => [
                'help' => 'Whether the password must not have been compromised in data leaks',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'compromisedThreshold' => [
            'help' => 'Number of times a password may appear in data leaks before it is considered compromised',
            'label' => [
                'help' => 'Number of times a password may appear in data leaks before it is considered compromised',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'new_password' => [
            'fields' => [
                'label' => 'new_password',
            ],
            'tooltip' => '',
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
        'change_password' => [
            'label' => 'Change Password',
            'modal' => [
                'heading' => 'Change Password',
                'description' => 'Enter the new password to confirm the change.',
            ],
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
