<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Welcome back to Laravel Pizza Meetups! 🍕',
        'subtitle' => 'Sign in to join meetups and manage your registrations.',
        'page_title' => 'Sign in',
    ],
    'logout' => [
        'in_progress' => 'Signing you out…',
    ],
    'password' => [
        'request' => [
            'title' => 'Forgot your password?',
            'subtitle' => 'Enter your account email and we\'ll send you a link to choose a new one.',
            'email' => 'Email',
            'submit' => 'Send me the link',
            'back_to_login' => 'Back to sign in',
        ],
        'reset' => [
            'title' => 'Choose a new password',
            'subtitle' => 'At least 8 characters. Once saved, you\'re signed in straight away.',
            'email' => 'Email',
            'password' => 'New password',
            'password_confirmation' => 'Repeat the new password',
            'submit' => 'Save password',
        ],
        'confirm' => [
            'title' => 'Confirm your password',
            'subtitle' => 'This is a protected area: enter your password again to continue.',
            'password' => 'Password',
            'submit' => 'Confirm',
            'forgot' => 'Forgot your password?',
        ],
    ],
    'verify' => [
        'title' => 'Check your email',
        'subtitle' => 'We sent you a link to confirm your email address. Open it to finish signing up.',
        'resent' => 'We sent you a new confirmation link.',
        'resend' => 'Didn\'t get it? Send another one',
        'logout' => 'Sign out',
    ],
];
