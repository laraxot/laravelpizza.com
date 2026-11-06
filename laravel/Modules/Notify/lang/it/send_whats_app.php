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
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci messaggio WhatsApp',
            'helper_text' => 'Testo del messaggio da inviare',
            'tooltip' => '',
            'description' => '',
        ],
        'template' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template',
            'help' => 'Template predefinito per il messaggio',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'recipient' => [
            'label' => 'recipient',
            'placeholder' => 'recipient',
            'helper_text' => 'recipient',
            'description' => 'recipient',
        ],
        'driver' => [
            'label' => 'driver',
            'placeholder' => 'driver',
            'helper_text' => 'driver',
            'description' => 'driver',
        ],
        'parameters' => [
            'label' => 'parameters',
            'placeholder' => 'parameters',
            'helper_text' => 'parameters',
            'description' => 'parameters',
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
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia WhatsApp',
            'tooltip' => 'Invia messaggio WhatsApp',
            'success' => 'Messaggio WhatsApp inviato con successo',
            'error' => 'Errore nell\'invio del messaggio WhatsApp',
        ],
        'whatsappFormActions' => [
            'label' => 'whatsappFormActions',
            'icon' => 'whatsappFormActions',
            'tooltip' => 'whatsappFormActions',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
        ],
        'add' => [
            'label' => 'add',
            'icon' => 'add',
            'tooltip' => 'add',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'reorder' => [
            'label' => 'reorder',
            'icon' => 'reorder',
            'tooltip' => 'reorder',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
    ],
    'label' => 'Send Whats App',
    'plural_label' => 'Send Whats App (Plurale)',
];
