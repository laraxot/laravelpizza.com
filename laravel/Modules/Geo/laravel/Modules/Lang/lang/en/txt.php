<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'tooltip' => 'Use a valid email address',
            'icon' => 'heroicon-o-mail',
            'description' => 'email',
            'helper_text' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'tooltip' => 'Password must contain at least 8 characters',
            'icon' => 'heroicon-o-lock-closed',
            'description' => 'password',
            'helper_text' => '',
        ],
        'remember' => [
            'label' => 'Remember me',
            'tooltip' => 'Keep me signed in on this device',
            'description' => 'remember',
            'helper_text' => '',
            'placeholder' => 'remember',
        ],
        'test' => [
            'label' => 'test',
            'placeholder' => 'test',
            'helper_text' => 'test',
            'description' => 'test',
            'tooltip' => '',
        ],
        'test_date' => [
            'label' => 'test_date',
            'placeholder' => 'test_date',
            'helper_text' => 'test_date',
            'description' => 'test_date',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'authenticate' => [
            'label' => 'Authenticate',
            'tooltip' => 'Sign in to the system',
            'icon' => 'ui-login',
            'color' => 'primary',
        ],
        'login' => [
            'label' => 'Sign in',
            'tooltip' => 'Sign in with your credentials',
            'icon' => 'heroicon-o-key',
            'color' => 'success',
        ],
        'request' => [
            'label' => 'request',
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
