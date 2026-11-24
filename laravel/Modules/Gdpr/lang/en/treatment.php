<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Processing Activities',
        'plural' => 'Processing Activities',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Data processing register',
        ],
        'label' => 'Processing Register',
        'sort' => '76',
        'icon' => 'gdpr-treatment',
    ],
    'fields' => [
        'name' => [
            'label' => 'Processing Name',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'purpose' => [
            'label' => 'Purpose',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'legal_basis' => [
            'label' => 'Base Giuridica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data_categories' => [
            'label' => 'Data Categories',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'retention_period' => [
            'label' => 'Retention Period',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'security_measures' => [
            'label' => 'Security Measures',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data_transfers' => [
            'label' => 'Data Transfers',
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
    'legal_bases' => [
        'consent' => 'Consent',
        'contract' => 'Contratto',
        'legal_obligation' => 'Obbligo Legale',
        'vital_interests' => 'Interessi Vitali',
        'public_interest' => 'Interesse Pubblico',
        'legitimate_interests' => 'Interessi Legittimi',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
