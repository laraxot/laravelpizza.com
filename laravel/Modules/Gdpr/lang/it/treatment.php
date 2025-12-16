<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Trattamenti',
        'plural' => 'Trattamenti',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Registro dei trattamenti dati',
        ],
        'label' => 'Registro Trattamenti',
        'sort' => 76,
        'icon' => 'gdpr-treatment',
    ],
    'fields' => [
        'name' => 'Nome Trattamento',
        'purpose' => 'Finalità',
        'legal_basis' => 'Base Giuridica',
        'data_categories' => 'Categorie di Dati',
        'retention_period' => 'Periodo di Conservazione',
        'security_measures' => 'Misure di Sicurezza',
        'data_transfers' => 'Trasferimenti Dati',
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
    ],
    'legal_bases' => [
        'consent' => 'Consenso',
        'contract' => 'Contratto',
        'legal_obligation' => 'Obbligo Legale',
        'vital_interests' => 'Interessi Vitali',
        'public_interest' => 'Interesse Pubblico',
        'legitimate_interests' => 'Interessi Legittimi',
    ],
];
