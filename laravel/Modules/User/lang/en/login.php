<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Enter your email address to log in',
            'description' => 'email',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Enter your account password',
            'description' => 'password',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Remember me',
            'placeholder' => '',
            'help' => 'Keep me logged in on this device',
            'description' => 'remember',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Full name',
            'placeholder' => 'Enter your full name',
            'help' => 'Your complete name for registration',
        ],
        'password_confirmation' => [
            'label' => 'Confirm password',
            'placeholder' => 'Repeat your password',
            'help' => 'Repeat the password for confirmation',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Sign in',
            'success' => 'Successfully logged in',
            'error' => 'Invalid credentials',
        ],
        'register' => [
            'label' => 'Sign up',
            'success' => 'Registration completed successfully',
            'error' => 'Unable to complete registration',
        ],
        'forgot_password' => [
            'label' => 'Forgot password?',
            'success' => 'Reset instructions sent to your email',
            'error' => 'Unable to send reset instructions',
        ],
        'reset_password' => [
            'label' => 'Reset password',
            'success' => 'Password reset successfully',
            'error' => 'Unable to reset password',
        ],
        'showPassword' => [
            'label' => 'showPassword',
            'icon' => 'showPassword',
            'tooltip' => 'showPassword',
        ],
        'hidePassword' => [
            'label' => 'hidePassword',
            'icon' => 'hidePassword',
            'tooltip' => 'hidePassword',
        ],
    ],
    'messages' => [
        'logout_success' => 'Successfully logged out',
        'logout_error' => 'An error occurred during logout',
        'user_not_allowed' => 'Your email is not authorized',
        'registration_not_enabled' => 'User registration is not allowed',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'general_error' => 'An error occurred. Please try again later.',
        'unauthorized' => 'You do not have the necessary permissions for this operation.',
    ],
];
