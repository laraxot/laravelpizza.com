<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Log di Autenticazione',
        'plural' => 'Log di Autenticazione',
        'icon' => 'heroicon-o-shield-check',
        'group' => 'Sicurezza',
        'sort' => 30,
    ],
    'label' => 'Log di Autenticazione',
    'plural_label' => 'Log di Autenticazione',
    'fields' => [
        'id' => ['label' => 'ID'],
        'authenticatable_type' => ['label' => 'Tipo Autenticabile'],
        'authenticatable.name' => ['label' => 'Utente'],
        'ip_address' => ['label' => 'Indirizzo IP'],
        'user_agent' => ['label' => 'User Agent'],
        'login_successful' => ['label' => 'Accesso Riuscito'],
        'login_at' => ['label' => 'Data Accesso'],
        'logout_at' => ['label' => 'Data Uscita'],
        'cleared_by_user' => ['label' => 'Cancellato da Utente'],
        'authenticatable_id' => ['label' => 'ID Autenticabile'],
    ],
    'actions' => [
        'view_user' => [
            'label' => 'Visualizza Utente',
            'icon' => 'heroicon-o-user',
        ],
    ],
];
