<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Privacy Events',
        'plural' => 'Privacy Events',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Privacy events register',
        ],
        'label' => 'Privacy Events',
        'sort' => '27',
        'icon' => 'gdpr-event',
    ],
    'fields' => [
        'event_type' => [
            'label' => 'Event Type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Description',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'label' => 'User',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timestamp' => [
            'label' => 'Date and Time',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'label' => 'Data',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'source' => [
            'label' => 'Source',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'event_types' => [
        'consent_granted' => 'Consent Granted',
        'consent_withdrawn' => 'Consent Revoked',
        'data_access' => 'Data Access',
        'data_modified' => 'Data Modified',
        'data_deleted' => 'Data Deleted',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
