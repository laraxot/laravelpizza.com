<?php

declare(strict_types=1);


return [
    'resource' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
    ],
    'navigation' => [
        'name' => 'Invio Telegram',
        'plural' => 'Invio Telegram',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di messaggi attraverso Telegram',
        ],
        'label' => 'Invio Telegram',
        'icon' => 'notify-telegram-animated',
        'sort' => '50',
    ],
    'fields' => [
        'chat_id' => [
            'label' => 'ID Chat',
            'placeholder' => 'Inserisci l\'ID della chat',
            'helper_text' => 'ID della chat Telegram di destinazione',
            'description' => 'Identificativo univoco della chat Telegram',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio da inviare',
            'helper_text' => 'Contenuto del messaggio Telegram',
            'description' => 'Testo del messaggio da inviare tramite Telegram',
        ],
        'parse_mode' => [
            'label' => 'Formato',
            'placeholder' => 'Seleziona il formato',
            'helper_text' => 'Formato di interpretazione del messaggio',
            'description' => 'Modalità di formattazione del messaggio',
            'options' => [
                'text' => 'Testo semplice',
                'html' => 'HTML',
                'markdown' => 'Markdown',
            ],
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Messaggio',
            'tooltip' => 'Invia un messaggio tramite Telegram',
            'success_message' => 'Messaggio inviato con successo',
            'error_message' => 'Errore nell\'invio del messaggio',
            'success' => 'Messaggio inviato con successo',
            'error' => 'Errore durante l\'invio del messaggio',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza un\'anteprima del messaggio',
            'success_message' => 'Anteprima generata',
            'error_message' => 'Errore nella generazione dell\'anteprima',
        ],
    ],
    'messages' => [
        'success' => 'Messaggio Telegram inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio del messaggio Telegram',
        'confirmation' => 'Sei sicuro di voler inviare questo messaggio Telegram?',
    ],
];
