<?php

declare(strict_types=1);


return [
    'navigation' => [
        'label' => 'Test SMTP',
        'group' => [
            'label' => 'Invia',
        ],
        'icon' => 'heroicon-o-envelope',
        'sort' => '50',
    ],
    'fields' => [
        'host' => [
            'label' => 'Host SMTP',
            'placeholder' => 'Inserisci l\'host SMTP (es. smtp.gmail.com)',
            'help' => 'Indirizzo del server SMTP per l\'invio delle email',
        ],
        'port' => [
            'label' => 'Porta',
            'placeholder' => 'Inserisci la porta (es. 587 per TLS, 465 per SSL)',
            'help' => 'Porta del server SMTP (587 per TLS, 465 per SSL, 25 per non crittografato)',
        ],
        'username' => [
            'label' => 'Username',
            'placeholder' => 'Inserisci lo username per l\'autenticazione',
            'help' => 'Username per l\'autenticazione SMTP (spesso l\'indirizzo email)',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => '••••••••',
            'help' => 'Password per l\'autenticazione SMTP (può essere una password specifica per app)',
        ],
        'encryption' => [
            'label' => 'Crittografia',
            'placeholder' => 'Seleziona il tipo di crittografia',
            'help' => 'Tipo di crittografia per la connessione SMTP (TLS, SSL, o nessuna)',
            'options' => [
                'tls' => 'TLS (Transport Layer Security)',
                'ssl' => 'SSL (Secure Sockets Layer)',
                'none' => 'Nessuna crittografia',
            ],
        ],
        'from_email' => [
            'label' => 'Email mittente',
            'placeholder' => 'mittente@dominio.com',
            'help' => 'Indirizzo email che apparirà come mittente della email di test',
        ],
        'from_name' => [
            'label' => 'Nome mittente',
            'placeholder' => 'Nome del mittente',
            'help' => 'Nome che apparirà come mittente della email di test',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'destinatario@dominio.com',
            'help' => 'Indirizzo email del destinatario per il test SMTP',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Test configurazione SMTP - {{app_name}}',
            'help' => 'Oggetto della email di test per verificare la configurazione',
        ],
        'body_html' => [
            'label' => 'Contenuto HTML',
            'placeholder' => '<h1>Test SMTP</h1><p>Questa è una email di test per verificare la configurazione SMTP.</p>',
            'help' => 'Contenuto HTML della email di test (opzionale)',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Test SMTP',
            'success' => 'Test SMTP inviato con successo! La configurazione è corretta.',
            'error' => 'Errore durante l\'invio del test SMTP. Verifica la configurazione.',
            'confirmation' => 'Sei sicuro di voler inviare una email di test?',
            'tooltip' => 'Invia una email di test per verificare la configurazione SMTP',
        ],
        'test_connection' => [
            'label' => 'Testa Connessione',
            'success' => 'Connessione SMTP stabilita con successo',
            'error' => 'Impossibile stabilire la connessione SMTP',
            'tooltip' => 'Testa solo la connessione senza inviare email',
        ],
    ],
    'messages' => [
        'success' => 'Test SMTP inviato con successo! Controlla la casella email del destinatario.',
        'error' => 'Si è verificato un errore durante l\'invio del test SMTP. Verifica i parametri di configurazione.',
        'connection_success' => 'Connessione SMTP stabilita correttamente',
        'connection_error' => 'Errore nella connessione SMTP. Verifica host, porta e credenziali.',
        'invalid_configuration' => 'Configurazione SMTP non valida. Verifica tutti i parametri.',
        'email_sent' => 'Email di test inviata correttamente al destinatario',
        'email_failed' => 'Impossibile inviare l\'email di test. Verifica la configurazione.',
    ],
    'validation' => [
        'host_required' => 'Der SMTP-Host ist erforderlich',
        'port_required' => 'La porta SMTP è obbligatoria',
        'port_numeric' => 'La porta deve essere un numero',
        'username_required' => 'Der SMTP-Benutzername ist erforderlich',
        'password_required' => 'La password SMTP è obbligatoria',
        'from_email_required' => 'L\'email mittente è obbligatoria',
        'from_email_valid' => 'L\'email mittente deve essere un indirizzo valido',
        'to_required' => 'L\'email destinatario è obbligatoria',
        'to_valid' => 'L\'email destinatario deve essere un indirizzo valido',
        'subject_required' => 'Der Betreff ist erforderlich',
    ],
];
