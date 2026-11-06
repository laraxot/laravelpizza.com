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
    ],
    'help' => [
        'title' => 'Guida alla configurazione',
        'description' => 'Configura le credenziali OAuth dei provider per consentire agli utenti di accedere con i loro account social.',
        'google_title' => 'Google OAuth',
        'google_step1' => 'Vai su <a href=":url" target="_blank" rel="noopener" class="underline">Google Cloud Console</a> e crea un progetto (o selezionane uno esistente).',
        'google_step2' => 'Abilita le API necessarie e configura la schermata di consenso OAuth.',
        'google_step3' => 'Crea le credenziali "ID client OAuth" di tipo applicazione web.',
        'google_step4' => 'Copia l\'ID client e il segreto client e incollali nel modulo qui sopra.',
        'redirect_url_note' => 'URL di reindirizzamento',
        'redirect_url_description' => 'Imposta come URI di reindirizzamento autorizzato l\'URL di callback mostrato nel modulo.',
    ],
    'security' => [
        'title' => 'Nota di sicurezza',
        'description' => 'Le credenziali sono salvate in modo sicuro. Non condividerle e non inserirle mai in repository pubblici.',
    ],
];
