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
        ],
        'message' => [
            'label' => 'Nachricht',
            'placeholder' => 'Nachrichtentext eingeben',
            'helper_text' => 'Nachricht darf 160 Zeichen nicht überschreiten',
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
];
