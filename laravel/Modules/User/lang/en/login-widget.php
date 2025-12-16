<?php

declare(strict_types=1);

return [
    'name' => 'Login',
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'helper_text' => 'Email address to login',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'helper_text' => 'Login password',
        ],
        'remember' => [
            'label' => 'Remember me',
            'helper_text' => 'Keep session active',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Login',
            'tooltip' => 'Sign in to your account',
        ],
        'forgot_password' => [
            'label' => 'Forgot Password?',
            'tooltip' => 'Reset your password',
        ],
        'register' => [
            'label' => 'Register',
            'tooltip' => 'Create a new account',
        ],
    ],
    'messages' => [
        'success' => [
            'login' => 'Successfully logged in',
        ],
        'error' => [
            'invalid_credentials' => 'Invalid credentials',
            'account_locked' => 'Account locked',
            'too_many_attempts' => 'Too many attempts, please try again later',
        ],
    ],
];
