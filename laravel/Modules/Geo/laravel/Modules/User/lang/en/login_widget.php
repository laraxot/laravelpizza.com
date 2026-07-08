<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email address',
            'placeholder' => 'name@example.com',
            'helper_text' => 'Email used to register for online services',
            'tooltip' => 'Enter your account email',
            'description' => 'Email field for authentication',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'helper_text' => '',
            'tooltip' => 'Account password',
            'description' => 'Password field for authentication',
        ],
        'remember' => [
            'label' => 'Remember me',
            'placeholder' => '',
            'helper_text' => 'Keep me signed in on this device',
            'tooltip' => 'Extended session',
            'description' => 'Remember login option',
        ],
    ],
    'actions' => [
        'hidePassword' => [
            'label' => 'Hide password',
            'tooltip' => 'Hide password',
            'icon' => 'hidePassword',
        ],
        'showPassword' => [
            'label' => 'Show password',
            'tooltip' => 'Show password',
            'icon' => 'showPassword',
        ],
    ],
];
