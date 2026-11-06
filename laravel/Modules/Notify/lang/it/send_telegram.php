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
        'sort' => 50,
    ],
    'fields' => [
        'chat_id' => [
            'label' => 'ID Chat',
            'placeholder' => 'Inserisci l\'ID della chat',
            'helper_text' => 'ID della chat Telegram di destinazione',
            'description' => 'Identificativo univoco della chat Telegram',
            'tooltip' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci il messaggio da inviare',
            'helper_text' => 'Contenuto del messaggio Telegram',
            'description' => 'Testo del messaggio da inviare tramite Telegram',
            'tooltip' => '',
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
            'tooltip' => '',
        ],
        'text' => [
            'label' => 'text',
            'placeholder' => 'text',
            'helper_text' => 'text',
            'description' => 'text',
        ],
        'driver' => [
            'label' => 'driver',
            'placeholder' => 'driver',
            'helper_text' => 'driver',
            'description' => 'driver',
        ],
        'disable_web_page_preview' => [
            'label' => 'disable_web_page_preview',
            'placeholder' => 'disable_web_page_preview',
            'helper_text' => 'disable_web_page_preview',
            'description' => 'disable_web_page_preview',
        ],
        'disable_notification' => [
            'label' => 'disable_notification',
            'placeholder' => 'disable_notification',
            'helper_text' => 'disable_notification',
            'description' => 'disable_notification',
        ],
        'reply_to_message_id' => [
            'label' => 'reply_to_message_id',
            'placeholder' => 'reply_to_message_id',
            'helper_text' => 'reply_to_message_id',
            'description' => 'reply_to_message_id',
        ],
        'media_url' => [
            'label' => 'media_url',
            'placeholder' => 'media_url',
            'helper_text' => 'media_url',
            'description' => 'media_url',
        ],
        'media_type' => [
            'label' => 'media_type',
            'placeholder' => 'media_type',
            'helper_text' => 'media_type',
            'description' => 'media_type',
        ],
        'caption' => [
            'label' => 'caption',
            'placeholder' => 'caption',
            'helper_text' => 'caption',
            'description' => 'caption',
        ],
        'recipient' => [
            'label' => 'recipient',
            'placeholder' => 'recipient',
            'helper_text' => 'recipient',
            'description' => 'recipient',
        ],
        'body' => [
            'label' => 'body',
            'placeholder' => 'body',
            'helper_text' => 'body',
            'description' => 'body',
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
        'emailFormActions' => [
            'label' => 'emailFormActions',
            'icon' => 'emailFormActions',
            'tooltip' => 'emailFormActions',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'telegramFormActions' => [
            'label' => 'telegramFormActions',
            'icon' => 'telegramFormActions',
            'tooltip' => 'telegramFormActions',
        ],
    ],
    'messages' => [
        'success' => 'Messaggio Telegram inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio del messaggio Telegram',
        'confirmation' => 'Sei sicuro di voler inviare questo messaggio Telegram?',
    ],
    'label' => 'Send Telegram',
    'plural_label' => 'Send Telegram (Plurale)',
    'sections' => [
        'empty' => [
            'label' => 'empty',
            'heading' => 'empty',
        ],
        'page' => [
            'title' => 'Test Invio Telegram',
            'description' => 'Utilizza questo form per testare l\'invio di messaggi Telegram tramite diversi provider.',
        ],
    ],
];
