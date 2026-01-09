<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Test SMTP',
        'group' => 'Notifiche',
        'icon' => 'heroicon-o-envelope-open',
        'sort' => 47,
    ],
    'label' => 'Test SMTP',
    'plural_label' => 'Test SMTP',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'host' => [
            'label' => 'Host',
        ],
        'port' => [
            'label' => 'Porta',
        ],
        'username' => [
            'label' => 'Nome utente',
        ],
        'password' => [
            'label' => 'Password',
        ],
        'encryption' => [
            'label' => 'Crittografia',
        ],
        'from_address' => [
            'label' => 'Indirizzo mittente',
        ],
        'from_name' => [
            'label' => 'Nome mittente',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'last_tested_at' => [
            'label' => 'Ultimo test il',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
    ],
    'actions' => [
        'send_test_email' => [
            'label' => 'Invia email di test',
        ],
        'test_connection' => [
            'label' => 'Test connessione',
        ],
    ],
];
