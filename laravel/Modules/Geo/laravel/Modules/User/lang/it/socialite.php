<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Accesso con social',
        'plural_label' => 'Accesso con social',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-share',
        'sort' => 90,
    ],
    'label' => 'Accesso con social',
    'plural_label' => 'Accesso con social',
    'fields' => [
        'provider' => [
            'label' => 'Provider',
            'placeholder' => 'Seleziona il provider',
            'help' => 'Provider OAuth per l\'accesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'provider_id' => [
            'label' => 'Provider ID',
            'placeholder' => 'Inserisci l\'ID del provider',
            'help' => 'Identificativo utente sul provider',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'token' => [
            'label' => 'Token',
            'placeholder' => 'Token di accesso',
            'help' => 'Token OAuth per l\'accesso',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'connect' => [
            'label' => 'Connetti',
            'tooltip' => 'Connetti account social',
        ],
        'disconnect' => [
            'label' => 'Disconnetti',
            'tooltip' => 'Disconnetti account social',
        ],
        'save' => 'Salva configurazione',
    ],
    'messages' => [
        'connected' => 'Account social connesso con successo',
        'disconnected' => 'Account social disconnesso con successo',
        'config_saved' => 'Configurazione OAuth salvata con successo. Effettua il logout e rientra per applicare le modifiche.',
    ],
    'page' => [
        'title' => 'Configurazione OAuth Providers',
        'description' => 'Configura i provider OAuth per l\'accesso social',
    ],
    'providers' => [
        'google' => [
            'enabled' => 'Attiva login con Google',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'scopes' => 'Scopes (permessi)',
            'redirect' => 'URL di redirect (copia in Google Console)',
        ],
        'github' => [
            'enabled' => 'Attiva login con GitHub',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'scopes' => 'Scopes (permessi)',
            'redirect' => 'URL di redirect (copia in GitHub Settings)',
        ],
        'microsoft' => [
            'enabled' => 'Attiva login con Microsoft',
            'client_id' => 'Client ID',
            'client_secret' => 'Client Secret',
            'scopes' => 'Scopes (permessi)',
            'redirect' => 'URL di redirect (copia in Azure AD)',
        ],
    ],
    'help' => [
        'title' => 'Guida alla configurazione OAuth',
        'description' => 'Per configurare l\'accesso con provider OAuth, devi prima creare un\'applicazione sul sito del provider e ottenere le credenziali (Client ID e Client Secret).',
        'google_title' => 'Configurazione Google OAuth',
        'google_step1' => 'Vai su <a href=":url" target="_blank" class="underline">Google Cloud Console</a> e crea un nuovo progetto',
        'google_step2' => 'Abilita le API necessarie (Google+ API o People API)',
        'google_step3' => 'Configura la schermata di consenso OAuth (tipo: Esterno)',
        'google_step4' => 'Crea credenziali OAuth 2.0 (tipo: Applicazione Web) e inserisci l\'URL di redirect mostrato sopra',
        'redirect_url_note' => 'Nota importante',
        'redirect_url_description' => 'L\'URL di redirect deve corrispondere esattamente a quello configurato nel provider OAuth (incluso http/https e trailing slash).',
    ],
    'security' => [
        'title' => 'Sicurezza',
        'description' => 'Le credenziali OAuth sono salvate in un file protetto (storage/app/private/socialite-config.php) con permessi restrictivi. Non vengono mai mostrate completamente nell\'interfaccia e non vengono incluse nei backup o nel codice sorgente.',
    ],
];
