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
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'otp_expiration_minutes' => [
            'help' => 'Durata in minuti della validità della password temporanea',
        ],
        'otp_length' => [
            'help' => 'Lunghezza del codice OTP',
        ],
        'expires_in' => [
            'help' => 'Il numero di giorni prima che la password scadrà',
        ],
        'min' => [
            'help' => 'La dimensione minima della password',
        ],
        'mixedCase' => [
            'help' => 'la password richiede almeno una lettera maiuscola e una minuscola',
        ],
        'letters' => [
            'help' => 'la password richiede almeno una lettera',
        ],
        'numbers' => [
            'help' => 'la password richiede almeno un numero',
        ],
        'symbols' => [
            'help' => 'la password richiede almeno un simbolo',
            'label' => [
                'help' => 'la password richiede almeno un simbolo',
            ],
        ],
        'uncompromised' => [
            'help' => 'Se la password non deve essere stata compromessa in data leaks',
            'label' => [
                'help' => 'Se la password non deve essere stata compromessa in data leaks',
            ],
        ],
        'compromisedThreshold' => [
            'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
            'label' => [
                'help' => 'Il numero di volte che una password può apparire in data leaks prima di essere considerata compromessa',
            ],
        ],
        'new_password' => [
            'label' => 'new_password',
            'fields' => [
                'label' => 'new_password',
            ],
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
];
