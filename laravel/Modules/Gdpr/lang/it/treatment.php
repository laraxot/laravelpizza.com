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
        'name' => [
            'label' => 'Nome Trattamento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'purpose' => [
            'label' => 'Finalità',
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
            'label' => 'Categorie di Dati',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'retention_period' => [
            'label' => 'Periodo di Conservazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'security_measures' => [
            'label' => 'Misure di Sicurezza',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data_transfers' => [
            'label' => 'Trasferimenti Dati',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
    'label' => 'Treatment',
    'plural_label' => 'Treatment (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Treatment',
        ],
        'edit' => [
            'label' => 'Modifica Treatment',
        ],
        'delete' => [
            'label' => 'Elimina Treatment',
        ],
    ],
];
