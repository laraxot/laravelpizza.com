<?php

declare(strict_types=1);

return [
    'fields' => [
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter the password',
            'help' => 'The password must be at least 8 characters',
            'validation' => [
                'required' => 'The password is required',
                'min' => 'The password must be at least 8 characters',
                'max' => 'The password may not exceed 255 characters',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Confirm the password',
            'help' => 'Re-enter the password to confirm',
            'validation' => [
                'required' => 'The password confirmation is required',
                'min' => 'The password must be at least 8 characters',
                'max' => 'The password may not exceed 255 characters',
                'same' => 'The passwords do not match',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
