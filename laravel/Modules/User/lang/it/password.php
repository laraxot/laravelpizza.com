<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Password',
        'plural' => 'Passwords',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'otp_expiration_minutes' => [
            'help' => 'Durata in minuti della validità della password temporanea',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'otp_length' => [
            'help' => 'Lunghezza del codice OTP',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'expires_in' => [
            'help' => 'Il numero di giorni prima che la password scadrà',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'min' => [
            'help' => 'La dimensione minima della password',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'mixedCase' => [
            'help' => 'la password richiede almeno una lettera maiuscola e una minuscola',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'letters' => [
            'help' => 'la password richiede almeno una lettera',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'numbers' => [
            'help' => 'la password richiede almeno un numero',
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'symbols' => [
            'help' => 'la password richiede almeno un simbolo',
            'label' => [
                'help' => 'la password richiede almeno un simbolo',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'uncompromised' => [
            'help' => 'Se la password non deve essere stata compromessa in data leaks',
            'label' => [
                'help' => 'Se la password non deve essere stata compromessa in data leaks',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'compromisedThreshold' => [
            'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
            'label' => [
                'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'new_password' => [
            'label' => 'new_password',
            'fields' => [
                'label' => 'new_password',
            ],
            'description' => 'new_password',
            'helper_text' => 'new_password',
            'placeholder' => 'new_password',
            'tooltip' => '',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'helper_text' => 'La password deve essere di almeno 8 caratteri',
            'description' => 'Password',
            'tooltip' => '',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password',
            'helper_text' => 'Reinserisci la password per confermare',
            'description' => 'Conferma Password',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'change_password' => 'Cambio password',
        'updateDataAction' => [
            'label' => 'updateDataAction',
        ],
    ],
    'label' => 'Password',
    'plural_label' => 'Password (Plurale)',
];
