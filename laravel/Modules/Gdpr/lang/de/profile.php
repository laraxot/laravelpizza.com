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
        'sort' => '22',
        'icon' => 'gdpr-profile',
    ],
    'fields' => [
        'user' => 'Utente',
        'preferences' => 'Preferenze',
        'marketing_consent' => 'Consenso Marketing',
        'analytics_consent' => 'Consenso Analytics',
        'third_party_consent' => 'Consenso Terze Parti',
        'last_updated' => 'Ultimo Aggiornamento',
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'preferences' => [
        'communication' => 'Preferenze Comunicazione',
        'data_retention' => 'Conservazione Dati',
        'data_sharing' => 'Condivisione Dati',
    ],
];
