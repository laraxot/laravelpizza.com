<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Eventi Privacy',
        'plural' => 'Eventi Privacy',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Registro degli eventi relativi alla privacy',
        ],
        'label' => 'Eventi Privacy',
        'sort' => '27',
        'icon' => 'gdpr-event',
    ],
    'fields' => [
        'event_type' => [
            'label' => 'Tipo Evento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'user' => [
            'label' => 'Utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'timestamp' => [
            'label' => 'Data e Ora',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'label' => 'Dati',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'source' => [
            'label' => 'Sorgente',
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
    'event_types' => [
        'consent_granted' => 'Consenso Concesso',
        'consent_withdrawn' => 'Consenso Revocato',
        'data_access' => 'Accesso ai Dati',
        'data_modified' => 'Dati Modificati',
        'data_deleted' => 'Dati Eliminati',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'actions' => [
    ],
];
