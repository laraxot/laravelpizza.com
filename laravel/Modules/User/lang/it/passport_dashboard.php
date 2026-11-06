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
        'client_name' => [
            'label' => 'Nome cliente',
        ],
        'force' => [
            'description' => 'force',
        ],
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
        ],
    ],
    'actions' => [
        'new_credentials' => [
            'label' => 'Nuove credenziali',
            'icon' => 'new_credentials',
            'tooltip' => 'new_credentials',
        ],
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
        'passport_install' => [
            'label' => 'passport_install',
            'icon' => 'passport_install',
            'tooltip' => 'passport_install',
        ],
        'passport_keys' => [
            'label' => 'passport_keys',
            'icon' => 'passport_keys',
            'tooltip' => 'passport_keys',
        ],
        'passport_purge' => [
            'label' => 'passport_purge',
            'icon' => 'passport_purge',
            'tooltip' => 'passport_purge',
        ],
        'passport_hash' => [
            'label' => 'passport_hash',
            'icon' => 'passport_hash',
            'tooltip' => 'passport_hash',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'submit',
            'tooltip' => 'submit',
        ],
        'cancel' => [
            'label' => 'cancel',
            'icon' => 'cancel',
            'tooltip' => 'cancel',
        ],
    ],
    'status' => [
        'public_key' => 'Chiave Pubblica',
        'private_key' => 'Chiave Privata',
        'present' => 'Presente',
        'missing' => 'Mancante',
        'completed' => [
            'message' => 'Completato',
        ],
        'failed' => [
            'message' => 'Fallito',
        ],
        'running' => [
            'message' => 'In esecuzione...',
        ],
    ],
    'messages' => [
        'client_created' => 'Client creato con successo',
        'client_revoked' => 'Client revocato con successo',
        'command_started' => 'Comando avviato...',
        'command_completed' => 'Comando completato con successo',
        'command_failed' => 'Esecuzione comando fallita',
        'command_error' => 'Errore durante l\'esecuzione del comando',
        'credentials_created' => 'Credenziali create con successo',
    ],
    'view' => [
        'running_notice' => [
            'message' => 'Il comando è in esecuzione. Non chiudere questa finestra.',
        ],
        'actions_disabled' => [
            'description' => 'Le altre azioni sono disabilitate fino al termine del comando.',
        ],
        'running_command' => [
            'message' => 'Comando in esecuzione: php artisan',
        ],
        'waiting_output' => [
            'message' => 'In attesa dell\'output...',
        ],
        'select_command' => [
            'label' => 'Seleziona un comando dall\'intestazione per iniziare.',
        ],
        'scroll' => [
            'helper_text' => 'Usa la rotellina del mouse per scorrere l\'output.',
        ],
    ],
];
