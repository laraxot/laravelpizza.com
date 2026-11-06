<?php

declare(strict_types=1);

// SettingPage del modulo (BaseSettingPage, Xot). Tutte le chiavi che AutoLabelAction legge sono
// scritte qui: senza, il primo render le crea con valori grezzi.
return [
    'navigation' => [
        'label' => 'Impostazioni',
        'group' => 'Configurazione',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 99,
    ],
    'title' => 'Impostazioni',
    'fields' => [
        'create_personal_team' => [
            'label' => 'Crea un team personale per ogni nuovo utente',
            'placeholder' => '',
            'helper_text' => 'Alla creazione di un utente viene creato anche il suo team personale, che diventa il team corrente.',
            'tooltip' => '',
            'description' => '',
        ],
        'passport_enable_password_grant' => [
            'label' => 'Abilita il password grant di Passport',
            'placeholder' => '',
            'helper_text' => 'Permette alle app di ottenere un token con email e password. Si applica al prossimo avvio dell\'applicazione.',
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-left-on-rectangle',
            'tooltip' => 'Esci',
        ],
    ],
];
