<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Indirizzo email',
            'placeholder' => 'nome@esempio.it',
            'helper_text' => 'L’indirizzo email usato per registrarti ai servizi online',
            'tooltip' => 'Inserisci l’email del tuo account',
            'description' => 'Campo email per l’autenticazione',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'helper_text' => '',
            'tooltip' => 'Password dell’account',
            'description' => 'Campo password per l’autenticazione',
        ],
        'remember' => ['label' => 'Ricordami'],
    ],
    'ui' => [
        'errors_title' => 'Controlla i dati inseriti',
        'login_button' => 'Accedi',
        'forgot_password' => 'Password dimenticata?',
    ],
];
