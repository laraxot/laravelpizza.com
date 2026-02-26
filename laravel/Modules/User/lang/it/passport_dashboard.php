<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Passport / API',
        'plural_label' => 'Passport / API',
        'group' => 'Sistema',
        'icon' => 'heroicon-o-key',
        'sort' => 95,
    ],
    'label' => 'Passport / API',
    'plural_label' => 'Passport / API',
    'fields' => [
        'client_id' => [
            'label' => 'Client ID',
            'placeholder' => 'Inserisci il client ID',
            'help' => 'Identificativo del client OAuth',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'client_secret' => [
            'label' => 'Client Secret',
            'placeholder' => 'Inserisci il client secret',
            'help' => 'Secret per l\'autenticazione OAuth',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Client',
            'tooltip' => 'Crea un nuovo client OAuth',
        ],
        'revoke' => [
            'label' => 'Revoca',
            'tooltip' => 'Revoca l\'accesso',
        ],
        'install' => [
            'label' => 'Installa Passport',
            'modal_description' => 'Questo comando installerà Passport e creerà le chiavi di crittografia necessarie.',
        ],
        'generate_keys' => [
            'label' => 'Genera Chiavi',
        ],
        'purge_tokens' => [
            'label' => 'Pulisci Token',
            'modal_description' => 'Elimina tutti i token scaduti o revocati.',
        ],
        'hash_secrets' => [
            'label' => 'Hash Secret',
            'modal_description' => 'Applica l\'hashing a tutti i client secret esistenti.',
        ],
    ],
    'status' => [
        'public_key' => 'Chiave Pubblica',
        'private_key' => 'Chiave Privata',
        'present' => 'Presente',
        'missing' => 'Mancante',
    ],
    'messages' => [
        'client_created' => 'Client creato con successo',
        'client_revoked' => 'Client revocato con successo',
        'command_started' => 'Comando avviato...',
        'command_completed' => 'Comando completato con successo',
        'command_failed' => 'Esecuzione comando fallita',
        'command_error' => 'Errore durante l\'esecuzione del comando',
    ],
];
