<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Enter the email address you used to register',
            'description' => 'Email address for login',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Enter your account password',
            'description' => 'Password for login',
        ],
        'remember' => [
            'label' => 'Remember me',
            'placeholder' => 'Keep session active',
            'help' => 'Select to keep your session active for 30 days',
            'description' => 'Option to remember login',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Login',
            'tooltip' => 'Click to access your account',
        ],
    ],
    'messages' => [
        'login_success' => 'Login successful',
        'login_error' => 'Error during login',
        'validation_error' => 'Validation error',
        'credentials_incorrect' => 'Incorrect credentials',
    ],
    'ui' => [
        'login_button' => 'Login',
        'forgot_password' => 'Forgot password?',
        'errors_title' => 'Some errors occurred',
    ],
];
