<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Conferma Reset Password',
        'plural_label' => 'Conferma Reset Password',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-lock-closed',
        'sort' => 8,
    ],
    'label' => 'Conferma Reset Password',
    'plural_label' => 'Conferma Reset Password',
    'fields' => [
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Indirizzo email',
            'placeholder' => 'Inserisci la tua email',
            'helper_text' => 'Inserisci il tuo indirizzo email',
            'description' => 'Email dell\'utente',
        ],
        'password' => [
            'label' => 'Password',
            'tooltip' => 'Nuova password',
            'placeholder' => 'Inserisci la nuova password',
            'helper_text' => 'Inserisci la nuova password',
            'description' => 'Nuova password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'tooltip' => 'Conferma la password',
            'placeholder' => 'Conferma la nuova password',
            'helper_text' => 'Ripeti la nuova password per conferma',
            'description' => 'Conferma della nuova password',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Conferma Reset',
            'tooltip' => 'Conferma il reset della password',
            'helper_text' => 'Conferma il reset della password',
            'description' => 'Azione per confermare',
        ],
    ],
    'messages' => [
        'success' => 'Password reimpostata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
