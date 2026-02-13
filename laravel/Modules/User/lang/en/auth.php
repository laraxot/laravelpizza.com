<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Your email address for authentication',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Your account password',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Sign in',
            'success' => 'Login successful',
            'error' => 'Invalid credentials',
        ],
        'logout' => [
            'label' => 'Logout',
            'success' => 'Logout successful',
            'error' => 'Logout failed',
        ],
    ],
    'messages' => [
        'failed' => 'These credentials do not match our records.',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthorized' => 'You are not authorized to access this resource.',
    ],
    // Password Reset Widget - specific translations
    'password_reset' => [
        'email_placeholder' => 'Enter your email address',
        'send_button' => 'Send reset link',
        'back_to_login' => 'Back to login',
        'send_another' => 'Send another link',
        'email_sent' => [
            'title' => 'Email sent!',
            'message' => 'We have sent you a password reset link. Check your email inbox and follow the instructions.',
        ],
        'email_failed' => [
            'title' => 'Sending error',
            'generic' => 'An error occurred while sending the email. Please try again later.',
        ],
        'password_requirements' => 'Password must be at least 8 characters',
        'processing' => 'Processing...',
        'instructions' => [
            'title' => 'Reset instructions',
            'description' => 'Enter your email and new password to complete the reset.',
        ],
        'confirm_button' => 'Confirm new password',
        'request_new_link' => 'Request a new link',
        'security' => [
            'title' => 'Security',
            'note' => 'The reset link is valid for 60 minutes and can only be used once.',
        ],
        'success' => [
            'title' => 'Password reset successfully!',
            'message' => 'Your password has been updated. You can now log in with your new password.',
            'redirect_notice' => 'Automatic redirect in progress...',
            'go_to_dashboard' => 'Go to dashboard',
            'go_to_login' => 'Go to login',
        ],
        'errors' => [
            'title' => 'Password reset error',
            'invalid_token' => 'The reset link is no longer valid or has expired.',
            'invalid_user' => 'Unable to find a user with this email address.',
            'generic' => 'An error occurred while resetting the password. Please try again later.',
            'possible_causes' => 'Possible causes:',
            'causes' => [
                'expired_token' => 'The reset link has expired (valid for 60 minutes)',
                'invalid_email' => 'The email address does not match any account',
                'already_used' => 'The reset link has already been used',
            ],
            'try_again' => 'Try again',
        ],
    ],
];
