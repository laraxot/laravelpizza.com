<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Password',
        'plural' => 'Password',
        'updateDataAction' => [
            'label' => 'Aggiorna dati',
            'icon' => 'heroicon-o-arrow-path',
            'tooltip' => 'Aggiorna i dati della password',
        ],
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'tooltip' => 'Salva la nuova password',
        ],
        'profile' => [
            'label' => 'Profilo',
            'icon' => 'heroicon-o-user-circle',
            'tooltip' => 'Torna al profilo',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'heroicon-o-arrow-right-on-rectangle',
            'tooltip' => 'Esci dall\'account',
        ],
        'group' => [
            'name' => 'Gestione account',
            'description' => 'Impostazioni e aggiornamento della password',
        ],
    ],
    'fields' => [
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Ripeti la password',
        ],
        'otp_expiration_minutes' => [
            'label' => 'Durata password temporanea (minuti)',
            'help' => 'Durata in minuti della validità della password temporanea',
        ],
        'otp_length' => [
            'label' => 'Lunghezza codice OTP',
            'help' => 'Lunghezza del codice OTP',
        ],
        'expires_in' => [
            'label' => 'Scadenza password (giorni)',
            'help' => 'Il numero di giorni prima che la password scada',
        ],
        'min' => [
            'label' => 'Lunghezza minima',
            'help' => 'La dimensione minima della password',
        ],
        'mixedCase' => [
            'label' => 'Maiuscole e minuscole',
            'help' => 'La password richiede almeno una lettera maiuscola e una minuscola',
        ],
        'letters' => [
            'label' => 'Lettere',
            'help' => 'La password richiede almeno una lettera',
        ],
        'numbers' => [
            'label' => 'Numeri',
            'help' => 'La password richiede almeno un numero',
        ],
        'symbols' => [
            'label' => 'Simboli',
            'help' => 'La password richiede almeno un simbolo',
        ],
        'uncompromised' => [
            'label' => 'Non compromessa',
            'help' => 'La password non deve comparire in data leak noti',
        ],
        'compromisedThreshold' => [
            'label' => 'Soglia di compromissione',
            'help' => 'Il numero di volte che una password può comparire in data leak prima di essere considerata compromessa',
        ],
    ],
    'actions' => [
        'change_password' => [
            'label' => 'Cambia password',
            'modal' => [
                'heading' => 'Cambia Password',
                'description' => 'Inserisci la nuova password per confermare il cambio.',
            ],
        ],
    ],
    'label' => 'Password',
    'plural_label' => 'Password (Plurale)',
];
