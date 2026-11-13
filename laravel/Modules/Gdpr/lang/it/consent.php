<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Consensi',
        'plural' => 'Consensi',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Gestione dei consensi privacy',
        ],
        'label' => 'Gestione Consensi',
        'sort' => 62,
        'icon' => 'gdpr-consent',
    ],
    'fields' => [
        'user' => [
            'label' => 'Utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo Consenso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'date' => [
            'label' => 'Data',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'ip_address' => [
            'label' => 'Indirizzo IP',
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
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
        ],
    ],
    'label' => 'Consent',
    'plural_label' => 'Consent (Plurale)',
];
