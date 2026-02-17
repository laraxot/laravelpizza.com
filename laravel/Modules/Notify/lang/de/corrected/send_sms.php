<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'SMS senden',
        'group' => 'Test',
    ],
    'fields' => [
        'to' => [
            'label' => 'Empfänger',
            'placeholder' => 'Telefonnummer eingeben',
            'helper_text' => 'Telefonnummer mit internationaler Vorwahl eingeben (z.B. +49)',
            'tooltip' => '',
            'description' => '',
        ],
        'message' => [
            'label' => 'Nachricht',
            'placeholder' => 'Nachrichtentext eingeben',
            'helper_text' => 'Nachricht darf 160 Zeichen nicht überschreiten',
            'tooltip' => '',
            'description' => '',
        ],
        'driver' => [
            'label' => 'Anbieter',
            'placeholder' => 'SMS-Anbieter auswählen',
            'helper_text' => 'Wählen Sie den Anbieter für den Versand',
            'options' => [
                'smsfactor' => 'SMSFactor',
                'twilio' => 'Twilio',
                'nexmo' => 'Nexmo',
                'plivo' => 'Plivo',
                'gammu' => 'Gammu',
                'netfun' => 'Netfun',
            ],
            'tooltip' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'SMS senden',
            'tooltip' => 'SMS-Nachricht an den Empfänger senden',
        ],
    ],
    'messages' => [
        'success' => 'SMS erfolgreich gesendet',
        'error' => 'Fehler beim Senden der SMS: :error',
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
