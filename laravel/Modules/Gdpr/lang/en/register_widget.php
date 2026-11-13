<?php

declare(strict_types=1);

return [
    'sections' => [
        'gdpr::register' => [
            'sections' => [
                'user_info' => [
                    'label' => 'gdpr::register.sections.user_info',
                    'heading' => 'gdpr::register.sections.user_info',
                ],
                'required_consents' => [
                    'label' => 'gdpr::register.sections.required_consents',
                    'heading' => 'gdpr::register.sections.required_consents',
                ],
                'optional_consents' => [
                    'label' => 'gdpr::register.sections.optional_consents',
                    'heading' => 'gdpr::register.sections.optional_consents',
                ],
            ],
        ],
    ],
    'fields' => [
        'first_name' => [
            'tooltip' => '',
        ],
        'last_name' => [
            'tooltip' => '',
        ],
        'email' => [
            'tooltip' => '',
        ],
        'password' => [
            'tooltip' => '',
        ],
        'password_confirmation' => [
            'tooltip' => '',
        ],
        'privacy_policy_accepted' => [
            'tooltip' => '',
        ],
        'terms_accepted' => [
            'tooltip' => '',
        ],
        'data_processing_accepted' => [
            'tooltip' => '',
        ],
        'marketing_consent' => [
            'tooltip' => '',
        ],
        'profiling_consent' => [
            'tooltip' => '',
        ],
        'analytics_consent' => [
            'tooltip' => '',
        ],
        'third_party_consent' => [
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
];
