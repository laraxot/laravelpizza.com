<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Indirizzo email',
            'placeholder' => 'esempio@comune.it',
            'helper_text' => 'Email usata per registrarti ai servizi online',
            'tooltip' => 'Inserisci l’indirizzo email dell’account',
            'description' => 'Campo email per l’autenticazione',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'helper_text' => '',
            'tooltip' => 'Password associata all’account',
            'description' => 'Campo password per l’autenticazione',
        ],
        'remember' => [
            'label' => 'Ricordami',
            'placeholder' => '',
            'helper_text' => 'Mantieni la sessione attiva su questo dispositivo',
            'tooltip' => 'Sessione prolungata',
            'description' => 'Opzione ricorda accesso',
        ],
    ],
    'actions' => [
        'hidePassword' => [
            'label' => 'Nascondi password',
            'tooltip' => 'Nascondi password',
            'icon' => 'hidePassword',
        ],
        'showPassword' => [
            'label' => 'Mostra password',
            'tooltip' => 'Mostra password',
            'icon' => 'showPassword',
        ],
    ],
];
