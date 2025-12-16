<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Telegram',
        'plural' => 'Telegram',
    ],
    'navigation' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione delle notifiche Telegram',
        ],
        'label' => 'Invio Telegram',
        'icon' => 'notify-telegram-animated',
        'sort' => '30',
    ],
    'fields' => [
        'chat_id' => [
            'label' => 'ID Chat',
            'placeholder' => 'Inserisci l\'ID della chat',
            'helper_text' => 'ID della chat Telegram a cui inviare il messaggio',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio',
            'helper_text' => 'Testo del messaggio da inviare',
        ],
        'parse_mode' => [
            'label' => 'Formato',
            'placeholder' => 'Seleziona il formato',
            'helper_text' => 'Formato di parsing del messaggio',
            'options' => [
                'text' => 'Testo semplice',
                'html' => 'HTML',
                'markdown' => 'Markdown',
            ],
        ],
        'driver' => [
            'label' => 'Provider Telegram',
            'placeholder' => 'Seleziona il provider Telegram',
            'helper_text' => 'Seleziona il provider Telegram da utilizzare',
        ],
    ],
    'drivers' => [
        'telegram' => 'Telegram',
        'botapi' => 'Bot API',
        'laravel_telegram' => 'Laravel Telegram',
    ],
    'actions' => [
        'send' => 'Invia Telegram',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Messaggio Telegram inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio del messaggio Telegram',
    ],
];
