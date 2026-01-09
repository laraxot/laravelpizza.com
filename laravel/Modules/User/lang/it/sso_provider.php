<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Provider SSO',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 41,
    ],
    'label' => 'Provider SSO',
    'plural_label' => 'Provider SSO',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
        'client_id' => [
            'label' => 'ID Client',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'redirect' => [
            'label' => 'Reindirizza',
        ],
        'active' => [
            'label' => 'Attivo',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => 'Attiva',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
        ],
        'test_connection' => [
            'label' => 'Test connessione',
        ],
    ],
];