<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport',
        'group' => 'Sicurezza',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 35,
    ],
    'label' => 'Passport',
    'plural_label' => 'Passport',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'client_id' => [
            'label' => 'Client ID',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
        ],
        'redirect' => [
            'label' => 'Reindirizza',
        ],
        'personal_access_client' => [
            'label' => 'Client per accesso personale',
        ],
        'password_client' => [
            'label' => 'Client per accesso con password',
        ],
        'revoked' => [
            'label' => 'Revocato',
        ],
    ],
    'actions' => [
        'create_client' => [
            'label' => 'Crea client',
        ],
        'revoke' => [
            'label' => 'Revoca',
        ],
        'install' => [
            'label' => 'Installa Passport',
            'modal_description' => 'Verrà eseguito passport:install --uuids. Verranno generate le chiavi e creati i client predefiniti.',
        ],
        'generate_keys' => [
            'label' => 'Genera Chiavi',
        ],
        'purge_tokens' => [
            'label' => 'Pulisci Token',
            'modal_description' => 'Verranno rimossi tutti i token scaduti e revocati dal database.',
        ],
        'hash_secrets' => [
            'label' => 'Hash Secret',
            'modal_description' => 'Verrà eseguito l\'hashing di tutti i secret dei client esistenti. Questa è un\'operazione a senso unico.',
        ],
        'create_personal' => [
            'label' => 'Crea Client Personale',
            'success' => 'Client di accesso personale creato.',
        ],
        'create_password' => [
            'label' => 'Crea Client Password',
            'success' => 'Client con grant password creato.',
        ],
        'create_client_credentials' => [
            'label' => 'Crea Client Credentials',
            'success' => 'Client con grant client credentials creato.',
        ],
    ],
    'status' => [
        'public_key' => 'Chiave Pubblica',
        'private_key' => 'Chiave Privata',
        'present' => 'Presente',
        'missing' => 'Mancante',
    ],
];
