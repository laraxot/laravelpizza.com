<?php

declare(strict_types=1);

return [
    'sections' => [
        'empty' => [
            'label' => 'empty',
            'heading' => 'empty',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'John',
            'helper_text' => '',
            'description' => 'Your given name',
            'tooltip' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Doe',
            'helper_text' => '',
            'description' => 'Your family name',
            'tooltip' => '',
        ],
        'email' => [
            'label' => 'Email Address',
            'placeholder' => 'john.doe@example.com',
            'helper_text' => 'Use your best email to receive updates.',
            'description' => 'Personal email',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter a secure password',
            'helper_text' => 'Minimum 12 characters, one uppercase, one number, and one symbol.',
            'description' => 'Access password',
            'tooltip' => '',
        ],
        'password_confirmation' => [
            'label' => 'Confirm Password',
            'placeholder' => 'Repeat password',
            'helper_text' => 'Must match the password entered above.',
            'description' => 'Password confirmation',
            'tooltip' => '',
        ],
        'privacy_policy_accepted' => [
            'label' => 'I accept the Privacy Policy',
            'placeholder' => '',
            'helper_text' => 'Required to register.',
            'description' => 'Privacy consent',
            'tooltip' => '',
        ],
        'marketing_consent' => [
            'label' => 'I want to receive updates (Marketing)',
            'placeholder' => '',
            'helper_text' => 'Optional. We will only send interesting stuff!',
            'description' => 'Marketing consent',
            'tooltip' => '',
        ],
        'third_party_consent' => [
            'label' => 'Third party consent',
            'placeholder' => '',
            'helper_text' => 'Optional.',
            'description' => 'Third party data consent',
            'tooltip' => '',
        ],
        'analytics_consent' => [
            'label' => 'Analytics consent',
            'placeholder' => '',
            'helper_text' => 'Optional.',
            'description' => 'Analytics consent',
            'tooltip' => '',
        ],
        'profiling_consent' => [
            'label' => 'Profiling consent',
            'helper_text' => 'Optional.',
            'description' => 'Profiling consent',
            'tooltip' => '',
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
    'actions' => [
    ],
];
