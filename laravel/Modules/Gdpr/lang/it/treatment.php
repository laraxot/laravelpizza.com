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
            'label' => 'Colonne',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'resetFilters' => [
            'label' => 'Azzera filtri',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'active' => [
            'label' => 'active',
        ],
        'required' => [
            'label' => 'required',
        ],
        'documentVersion' => [
            'label' => 'documentVersion',
        ],
        'documentUrl' => [
            'label' => 'documentUrl',
        ],
        'weight' => [
            'label' => 'weight',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
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
    'label' => 'Trattamento',
    'plural_label' => 'Trattamenti',
    'actions' => [
        'create' => [
            'label' => 'Crea trattamento',
        ],
        'edit' => [
            'label' => 'Modifica trattamento',
        ],
        'delete' => [
            'label' => 'Elimina trattamento',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
        ],
        'createAnother' => [
            'label' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'cancel',
        ],
    ],
];
