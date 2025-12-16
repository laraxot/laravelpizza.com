<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'WhatsApp',
        'group' => 'Notify',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 10,
    ],
    'fields' => [
        'phone_number' => [
            'label' => 'Numero Telefono',
            'placeholder' => 'Inserisci numero WhatsApp',
            'helper_text' => 'Numero di telefono per l\'invio WhatsApp',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci messaggio WhatsApp',
            'helper_text' => 'Testo del messaggio da inviare',
        ],
        'template' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template',
            'help' => 'Template predefinito per il messaggio',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia WhatsApp',
            'tooltip' => 'Invia messaggio WhatsApp',
            'success' => 'Messaggio WhatsApp inviato con successo',
            'error' => 'Errore nell\'invio del messaggio WhatsApp',
        ],
    ],
];
