<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Canale di Notifica',
    ],
    'navigation' => [
        'group' => 'Sistema',
        'label' => 'Canali di Notifica',
        'icon' => 'notify-channel-animated',
        'sort' => '47',
        'description' => 'Gestione dei canali di comunicazione per le notifiche',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome identificativo del canale',
            'placeholder' => 'es: Email Marketing',
            'help' => 'Inserisci un nome univoco per identificare il canale',
        ],
        'driver' => [
            'label' => 'Driver',
            'tooltip' => 'Tipo di servizio utilizzato per l\'invio',
            'help' => 'Seleziona il driver appropriato per questo canale',
            'options' => [
                'mail' => [
                    'label' => 'Email',
                    'tooltip' => 'Invio tramite server SMTP',
                ],
                'database' => [
                    'label' => 'Database',
                    'tooltip' => 'Salvataggio nel database',
                ],
                'broadcast' => [
                    'label' => 'Broadcast',
                    'tooltip' => 'Invio tramite websocket',
                ],
                'sms' => [
                    'label' => 'SMS',
                    'tooltip' => 'Invio tramite gateway SMS',
                ],
                'telegram' => [
                    'label' => 'Telegram',
                    'tooltip' => 'Invio tramite bot Telegram',
                ],
                'slack' => [
                    'label' => 'Slack',
                    'tooltip' => 'Invio tramite webhook Slack',
                ],
            ],
        ],
        'configuration' => [
            'label' => 'Configurazione',
            'tooltip' => 'Parametri di configurazione del canale',
            'help' => 'Configura i parametri necessari per il funzionamento del canale',
            'options' => [
                'host' => [
                    'label' => 'Host',
                    'tooltip' => 'Indirizzo del server',
                    'placeholder' => 'es: smtp.gmail.com',
                ],
                'port' => [
                    'label' => 'Porta',
                    'tooltip' => 'Porta di connessione',
                    'placeholder' => 'es: 587',
                ],
                'username' => [
                    'label' => 'Username',
                    'tooltip' => 'Nome utente per l\'autenticazione',
                    'placeholder' => 'es: user@example.com',
                ],
                'password' => [
                    'label' => 'Password',
                    'tooltip' => 'Password per l\'autenticazione',
                    'help' => 'La password verrà criptata prima del salvataggio',
                ],
                'encryption' => [
                    'label' => 'Crittografia',
                    'tooltip' => 'Metodo di crittografia',
                    'options' => [
                        'tls' => [
                            'label' => 'TLS',
                            'tooltip' => 'Transport Layer Security',
                        ],
                        'ssl' => [
                            'label' => 'SSL',
                            'tooltip' => 'Secure Sockets Layer',
                        ],
                    ],
                ],
                'from_address' => [
                    'label' => 'Indirizzo mittente',
                    'tooltip' => 'Indirizzo email del mittente',
                    'placeholder' => 'es: noreply@example.com',
                ],
                'from_name' => [
                    'label' => 'Nome mittente',
                    'tooltip' => 'Nome visualizzato del mittente',
                    'placeholder' => 'es: Sistema Notifiche',
                ],
                'api_key' => [
                    'label' => 'API Key',
                    'tooltip' => 'Chiave API per l\'autenticazione',
                    'help' => 'Chiave fornita dal servizio per l\'autenticazione',
                ],
                'api_secret' => [
                    'label' => 'API Secret',
                    'tooltip' => 'Chiave segreta API',
                    'help' => 'Non condividere mai questa chiave',
                ],
                'bot_token' => [
                    'label' => 'Token Bot',
                    'tooltip' => 'Token del bot Telegram',
                    'help' => 'Ottieni il token da @BotFather su Telegram',
                ],
                'chat_id' => [
                    'label' => 'ID Chat',
                    'tooltip' => 'ID della chat Telegram',
                    'help' => 'ID del gruppo o canale Telegram',
                ],
                'webhook_url' => [
                    'label' => 'URL Webhook',
                    'tooltip' => 'URL per le chiamate webhook',
                    'placeholder' => 'es: https://hooks.slack.com/services/...',
                ],
            ],
        ],
        'is_default' => [
            'label' => 'Predefinito',
            'tooltip' => 'Imposta come canale predefinito',
            'help' => 'Il canale predefinito verrà utilizzato quando non specificato diversamente',
        ],
        'is_enabled' => [
            'label' => 'Abilitato',
            'tooltip' => 'Stato di attivazione del canale',
            'help' => 'Disabilita temporaneamente il canale senza eliminarlo',
        ],
    ],
    'actions' => [
        'test_connection' => [
            'label' => 'Testa connessione',
            'tooltip' => 'Verifica la configurazione del canale',
            'icon' => 'heroicon-o-signal',
            'color' => 'info',
        ],
        'send_test' => [
            'label' => 'Invia test',
            'tooltip' => 'Invia un messaggio di test',
            'icon' => 'heroicon-o-paper-airplane',
            'color' => 'primary',
            'confirmation' => [
                'title' => 'Conferma test',
                'message' => 'Vuoi inviare un messaggio di test?',
                'confirm' => 'Sì, invia',
                'cancel' => 'No, annulla',
            ],
        ],
    ],
    'messages' => [
        'connection_success' => [
            'title' => 'Connessione Riuscita',
            'message' => 'La connessione al canale è stata stabilita con successo',
        ],
        'connection_failed' => [
            'title' => 'Errore di Connessione',
            'message' => 'Impossibile connettersi al canale: :error',
        ],
        'test_sent' => [
            'title' => 'Test Inviato',
            'message' => 'Il messaggio di test è stato inviato con successo',
        ],
        'test_failed' => [
            'title' => 'Errore Test',
            'message' => 'Impossibile inviare il messaggio di test: :error',
        ],
    ],
];
