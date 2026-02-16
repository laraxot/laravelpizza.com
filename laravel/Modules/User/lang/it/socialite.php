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
        ],
        'provider_id' => [
            'label' => 'Provider ID',
            'placeholder' => 'Inserisci l\'ID del provider',
            'help' => 'Identificativo utente sul provider',
        ],
        'token' => [
            'label' => 'Token',
            'placeholder' => 'Token di accesso',
            'help' => 'Token OAuth per l\'accesso',
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
    ],
    'messages' => [
        'connected' => 'Account social connesso con successo',
        'disconnected' => 'Account social disconnesso con successo',
    ],
];
