<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Consents',
        'plural' => 'Consents',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Manage privacy consents',
        ],
        'label' => 'Consent Management',
        'sort' => '62',
        'icon' => 'gdpr-consent',
    ],
    'fields' => [
        'user' => [
            'label' => 'User',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Consent Type',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'date' => [
            'label' => 'Date',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ip_address' => [
            'label' => 'IP Address',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'notes' => [
            'label' => 'Note',
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
    ],
    'statuses' => [
        'granted' => 'Concesso',
        'denied' => 'Negato',
        'withdrawn' => 'Revocato',
        'expired' => 'Scaduto',
    ],
    'actions' => [
        'grant' => 'Concedi',
        'deny' => 'Nega',
        'withdraw' => 'Revoca',
        'renew' => 'Rinnova',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
