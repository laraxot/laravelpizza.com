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
            'label' => 'first_name',
            'placeholder' => 'first_name',
            'helper_text' => 'first_name',
            'description' => 'first_name',
        ],
        'last_name' => [
            'label' => 'last_name',
            'placeholder' => 'last_name',
            'helper_text' => 'last_name',
            'description' => 'last_name',
        ],
        'email' => [
            'label' => 'email',
            'placeholder' => 'email',
            'helper_text' => 'email',
            'description' => 'email',
        ],
        'password' => [
            'label' => 'password',
            'placeholder' => 'password',
            'helper_text' => 'password',
            'description' => 'password',
        ],
        'password_confirmation' => [
            'label' => 'password_confirmation',
            'placeholder' => 'password_confirmation',
            'helper_text' => 'password_confirmation',
            'description' => 'password_confirmation',
        ],
        'privacy_policy_accepted' => [
            'label' => 'privacy_policy_accepted',
            'placeholder' => 'privacy_policy_accepted',
            'helper_text' => 'privacy_policy_accepted',
            'description' => 'privacy_policy_accepted',
        ],
        'terms_accepted' => [
            'label' => 'terms_accepted',
            'placeholder' => 'terms_accepted',
            'helper_text' => 'terms_accepted',
            'description' => 'terms_accepted',
        ],
        'data_processing_accepted' => [
            'label' => 'data_processing_accepted',
            'placeholder' => 'data_processing_accepted',
            'helper_text' => 'data_processing_accepted',
            'description' => 'data_processing_accepted',
        ],
        'marketing_consent' => [
            'label' => 'marketing_consent',
            'placeholder' => 'marketing_consent',
            'helper_text' => 'marketing_consent',
            'description' => 'marketing_consent',
        ],
        'profiling_consent' => [
            'label' => 'profiling_consent',
            'placeholder' => 'profiling_consent',
            'helper_text' => 'profiling_consent',
            'description' => 'profiling_consent',
        ],
        'analytics_consent' => [
            'label' => 'analytics_consent',
            'placeholder' => 'analytics_consent',
            'helper_text' => 'analytics_consent',
            'description' => 'analytics_consent',
        ],
        'third_party_consent' => [
            'label' => 'third_party_consent',
            'placeholder' => 'third_party_consent',
            'helper_text' => 'third_party_consent',
            'description' => 'third_party_consent',
        ],
    ],
];
