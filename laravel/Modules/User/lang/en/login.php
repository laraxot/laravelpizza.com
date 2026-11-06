<?php

declare(strict_types=1);

return [
    'logout_in_progress' => 'Signing out…',
    'email_verified' => 'Email address verified. Thank you!',
    'password_reset_page' => [
        'title' => 'Reset your password',
        'intro' => 'Enter your account email and we will send you a link to choose a new password.',
        'return_to_login' => 'Back to sign in',
        'email_label' => 'Email address',
        'submit' => 'Send reset link',
    ],
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Enter your email address to log in',
            'description' => 'email',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Enter your account password',
            'description' => 'password',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'remember' => [
            'label' => 'Remember me',
            'placeholder' => '',
            'help' => 'Keep me logged in on this device',
            'description' => 'remember',
            'helper_text' => '',
            'tooltip' => '',
        ],
        'name' => [
            'label' => 'Full name',
            'placeholder' => 'Enter your full name',
            'help' => 'Your complete name for registration',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirm password',
            'placeholder' => 'Repeat your password',
            'help' => 'Repeat the password for confirmation',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Login',
            'success' => 'Successfully logged in',
            'error' => 'Invalid credentials',
            'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        ],
        'register' => [
            'label' => 'Register',
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
    ],
    'no_account' => 'Do not have an account yet?',
    'register_now' => 'Create your account',
    'forgot_password_text' => 'Forgot your password?',
    'reset_it' => 'Reset it',
    'messages' => [
        'logout_success' => 'Successfully logged out',
        'logout_error' => 'An error occurred during logout',
        'user_not_allowed' => 'Your email is not authorized',
        'registration_not_enabled' => 'User registration is not allowed',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'general_error' => 'An error occurred. Please try again later.',
        'unauthorized' => 'You do not have the necessary permissions for this operation.',
    ],
    'page' => [
        'title' => 'Log in to FixCity',
        'subtitle' => 'Sign in to report a problem and follow your cases',
    ],
    'already_registered' => 'Don\'t have an account yet?',
    'register' => 'Register now',
];
