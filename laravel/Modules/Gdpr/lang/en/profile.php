<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Privacy Profiles',
        'plural' => 'Privacy Profiles',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Manage user privacy profiles',
        ],
        'label' => 'Privacy Profiles',
        'sort' => '22',
        'icon' => 'gdpr-profile',
    ],
    'fields' => [
        'user' => [
            'label' => 'User',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'preferences' => [
            'label' => 'Preferenze',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'marketing_consent' => [
            'label' => 'Marketing Consent',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'analytics_consent' => [
            'label' => 'Analytics Consent',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'third_party_consent' => [
            'label' => 'Third-party Consent',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_updated' => [
            'label' => 'Last Updated',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'preferences' => [
        'communication' => 'Preferenze Comunicazione',
        'data_retention' => 'Data Retention',
        'data_sharing' => 'Data Sharing',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
