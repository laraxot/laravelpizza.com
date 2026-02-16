<?php

declare(strict_types=1);

return [
    'name' => 'Login',
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'helper_text' => 'Indirizzo email per accedere',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password',
            'helper_text' => 'Password di accesso',
        ],
        'remember' => [
            'label' => 'Ricordami',
            'helper_text' => 'Mantieni la sessione attiva',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Accedi',
            'tooltip' => 'Effettua il login',
        ],
        'forgot_password' => [
            'label' => 'Password dimenticata?',
            'tooltip' => 'Recupera la password',
        ],
        'register' => [
            'label' => 'Registrati',
            'tooltip' => 'Crea un nuovo account',
        ],
    ],
    'messages' => [
        'success' => [
            'login' => 'Login effettuato con successo',
        ],
        'error' => [
            'invalid_credentials' => 'Credenziali non valide',
            'account_locked' => 'Account bloccato',
            'too_many_attempts' => 'Troppi tentativi, riprova più tardi',
        ],
    ],
    'navigation' => [],
    'label' => '',
    'plural_label' => '',
];
