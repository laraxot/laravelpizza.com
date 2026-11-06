<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
    ],
    'sections' => [
        'basic' => [
            'title' => 'Informazioni di base',
        ],
        'yes' => [
            'label' => 'Sì',
        ],
        'personal_access' => [
            'label' => 'Accesso personale',
        ],
        'configuration' => [
            'title' => 'Configurazione',
        ],
        'grant_types' => [
            'title' => 'Grant Types',
        ],
        'redirect_uris' => [
            'title' => 'Redirect URI',
        ],
        'scopes' => [
            'title' => 'Scope',
        ],
        'owner' => [
            'title' => 'Informazioni sul proprietario',
        ],
    ],
    'basic' => [
        'name' => [
            'label' => 'Nome',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'show' => [
            'label' => 'Mostra',
        ],
        'no_secret' => [
            'message' => 'Nessun secret',
        ],
        'provider' => [
            'label' => 'Provider',
        ],
        'default_provider' => [
            'label' => 'Predefinito',
        ],
        'created' => [
            'label' => 'Creato',
        ],
        'updated' => [
            'label' => 'Aggiornato',
        ],
    ],
    'messages' => [
        'not_available' => [
            'message' => 'N/D',
        ],
        'no' => [
            'message' => 'No',
        ],
    ],
    'configuration' => [
        'confidential' => [
            'label' => 'Riservato',
        ],
        'first_party' => [
            'label' => 'Prima parte',
        ],
        'password_client' => [
            'label' => 'Client password',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
    ],
    'grant_types' => [
        'authorization_code' => [
            'label' => 'Authorization Code',
        ],
        'client_credentials' => [
            'label' => 'Client Credentials',
        ],
        'refresh_token' => [
            'label' => 'Refresh Token',
        ],
        'implicit' => [
            'label' => 'Implicit',
        ],
        'none' => [
            'message' => 'Nessun grant type configurato',
        ],
    ],
    'owner' => [
        'id' => [
            'label' => 'ID proprietario',
        ],
        'type' => [
            'label' => 'Tipo proprietario',
        ],
        'name' => [
            'label' => 'Nome proprietario',
        ],
    ],
];
