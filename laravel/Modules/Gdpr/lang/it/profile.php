<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Profili Privacy',
        'plural' => 'Profili Privacy',
        'group' => [
            'name' => 'GDPR',
            'description' => 'Gestione dei profili di privacy degli utenti',
        ],
        'label' => 'Profili Privacy',
        'sort' => 22,
        'icon' => 'gdpr-profile',
    ],
    'fields' => [
        'user' => [
            'label' => 'Utente',
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
            'label' => 'Consenso Marketing',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'analytics_consent' => [
            'label' => 'Consenso Analytics',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'third_party_consent' => [
            'label' => 'Consenso Terze Parti',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_updated' => [
            'label' => 'Ultimo Aggiornamento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica filtri',
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
        'type' => [
            'label' => 'type',
        ],
        'first_name' => [
            'label' => 'first_name',
        ],
        'last_name' => [
            'label' => 'last_name',
        ],
        'full_name' => [
            'label' => 'full_name',
        ],
        'email' => [
            'label' => 'email',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'user_id' => [
            'label' => 'user_id',
        ],
        'updated_by' => [
            'label' => 'updated_by',
        ],
        'created_by' => [
            'label' => 'created_by',
        ],
        'deleted_at' => [
            'label' => 'deleted_at',
        ],
        'deleted_by' => [
            'label' => 'deleted_by',
        ],
        'is_active' => [
            'label' => 'is_active',
        ],
    ],
    'preferences' => [
        'communication' => 'Preferenze Comunicazione',
        'data_retention' => 'Conservazione Dati',
        'data_sharing' => 'Condivisione Dati',
    ],
    'label' => 'Profilo',
    'plural_label' => 'Profili',
    'actions' => [
        'create' => [
            'label' => 'Crea profilo',
        ],
        'edit' => [
            'label' => 'Modifica profilo',
        ],
        'delete' => [
            'label' => 'Elimina profilo',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'label' => 'profile',
        ],
    ],
];
