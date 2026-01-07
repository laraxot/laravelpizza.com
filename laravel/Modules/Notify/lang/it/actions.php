<?php

declare(strict_types=1);

return [
    'send_notification_bulk' => [
        'label' => 'Invia notifiche',
        'form' => [
            'template_slug' => [
                'label' => 'Template',
                'placeholder' => 'Seleziona un template',
                'helper_text' => 'Seleziona il template di notifica da utilizzare',
            ],
            'channels' => [
                'label' => 'Canali',
                'helper_text' => 'Seleziona uno o più canali di invio',
                'options' => [
                    'mail' => 'Email',
                    'sms' => 'SMS',
                    'whatsapp' => 'WhatsApp',
                ],
            ],
        ],
        'errors' => [
            'unsupported_channel' => 'Canale :channel non supportato',
            'email_not_available' => 'Email non disponibile per questo record',
            'phone_not_available' => 'Numero di telefono non disponibile per questo record',
            'whatsapp_not_available' => 'Numero WhatsApp non disponibile per questo record',
            'channel_not_sent' => 'Canale non inviato (dati non disponibili)',
        ],
        'notifications' => [
            'success' => [
                'title' => 'Notifiche inviate',
                'body' => 'Inviate :count notifiche su :total con successo',
            ],
            'warning' => [
                'title' => 'Dati non validi',
                'invalid_data' => 'Template e almeno un canale devono essere selezionati',
            ],
            'error' => [
                'title' => 'Alcune notifiche non sono state inviate',
                'item' => 'Record :record (canale :channel): :error',
                'more_errors' => '... e altri :count errori',
            ],
        ],
    ],
];
