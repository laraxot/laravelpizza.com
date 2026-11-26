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
        'sort' => 27,
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
        'applyFilters' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'treatment_id' => [
            'label' => 'treatment_id',
        ],
        'consent' => [
            'id' => [
                'label' => 'consent.id',
            ],
        ],
        'subject_id' => [
            'label' => 'subject_id',
        ],
        'ip' => [
            'label' => 'ip',
        ],
        'action' => [
            'label' => 'action',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
    ],
    'event_types' => [
        'consent_granted' => 'Consenso Concesso',
        'consent_withdrawn' => 'Consenso Revocato',
        'data_access' => 'Accesso ai Dati',
        'data_modified' => 'Dati Modificati',
        'data_deleted' => 'Dati Eliminati',
    ],
    'label' => 'Evento',
    'plural_label' => 'Eventi',
    'actions' => [
        'create' => [
            'label' => 'Crea evento',
        ],
        'edit' => [
            'label' => 'Modifica evento',
        ],
        'delete' => [
            'label' => 'Elimina evento',
        ],
        'profile' => [
            'label' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
        ],
    ],
];
