<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Registrazione',
        'plural_label' => 'Registrazione',
        'group' => 'Autenticazione',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 10,
    ],
    'label' => 'Registrazione',
    'plural_label' => 'Registrazione',
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome',
            'help' => 'Il tuo nome completo',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email',
            'help' => 'Indirizzo email valido',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Crea una password sicura',
            'help' => 'Minimo 8 caratteri',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Ripeti la password',
            'help' => 'Ripeti la password per conferma',
        ],
    ],
    'actions' => [
        'register' => [
            'label' => 'Registrati',
            'tooltip' => 'Crea un nuovo account',
        ],
    ],
    'messages' => [
        'registered' => 'Registrazione completata con successo',
        'error' => 'Errore durante la registrazione',
    ],
];
