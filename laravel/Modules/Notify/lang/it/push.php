<?php

declare(strict_types=1);

return [
    'form' => [
        'token' => [
            'label' => 'Token del dispositivo',
            'helper' => 'Token FCM del dispositivo che riceve la prova',
        ],
        'title' => [
            'label' => 'Titolo',
        ],
        'body' => [
            'label' => 'Testo',
        ],
        'image_url' => [
            'label' => 'Immagine (URL)',
            'helper' => 'Facoltativo',
        ],
        'notification_type' => [
            'label' => 'Tipo di notifica',
        ],
        'high_priority' => [
            'label' => 'Priorità alta',
            'helper' => 'Consegna immediata anche con il dispositivo in risparmio energetico',
        ],
        'custom_data' => [
            'label' => 'Dati aggiuntivi',
            'helper' => 'Coppie chiave/valore inviate con la notifica',
            'key_label' => 'Chiave',
            'value_label' => 'Valore',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
    ],
    'notifications' => [
        'sent' => [
            'title' => 'Notifica inviata',
            'body' => 'La notifica push è stata inviata',
        ],
        'error' => [
            'title' => 'Invio non riuscito',
        ],
    ],
];
