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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'host' => [
            'label' => 'Host',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'port' => [
            'label' => 'Porta',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'username' => [
            'label' => 'Nome utente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password' => [
            'label' => 'Password',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'encryption' => [
            'label' => 'Crittografia',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_address' => [
            'label' => 'Indirizzo mittente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'from_name' => [
            'label' => 'Nome mittente',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_tested_at' => [
            'label' => 'Ultimo test il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
