<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email address',
            'placeholder' => 'name@example.com',
            'helper_text' => 'Use the email address you will use to sign in.',
            'description' => 'Email',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter a strong password',
            'helper_text' => 'At least 12 characters, with an uppercase letter, a number and a symbol.',
            'description' => 'Account password',
        ],
        'remember' => [
            'label' => 'Remember me',
            'placeholder' => '',
            'helper_text' => 'Prolonged session on a trusted device',
            'description' => 'Keep the session active on this device',
        ],
        'first_name' => [
            'label' => 'First name',
            'placeholder' => 'John',
            'helper_text' => 'Your given name',
            'description' => 'First name',
        ],
        'last_name' => [
            'label' => 'Last name',
            'placeholder' => 'Smith',
            'helper_text' => 'Your family name',
            'description' => 'Last name',
        ],
        'password_confirmation' => [
            'label' => 'Confirm password',
            'placeholder' => 'Repeat your password',
            'helper_text' => 'Must match the password entered above.',
            'description' => 'Confirm password',
        ],
    ],
    'actions' => [
        'showPassword' => [
            'label' => 'Show password',
            'icon' => 'heroicon-o-eye',
            'tooltip' => 'Show password',
        ],
        'hidePassword' => [
            'label' => 'Hide password',
            'icon' => 'heroicon-o-eye-slash',
            'tooltip' => 'Hide password',
        ],
    ],
];
