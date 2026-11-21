<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Send Push Notification',
    ],
    'navigation' => [
        'name' => 'Send Push Notification',
        'plural' => 'Send Push Notifications',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Send push notifications via Firebase',
        ],
        'label' => 'Send Push Notifications',
        'icon' => 'notify-push-animated',
        'sort' => '51',
    ],
    'fields' => [
        'device_token' => [
            'label' => 'Token Dispositivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'options' => [
                'notification' => 'Notification',
                'data' => 'Dati',
                'both' => 'Entrambi',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'title' => [
            'label' => 'Titolo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'body' => [
            'label' => 'Contenuto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'data' => [
            'label' => 'Dati Aggiuntivi',
            'description' => 'JSON data to send with the notification',
            'tooltip' => '',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Send Notification',
            'success' => 'Push notification sent successfully',
            'error' => 'Error while sending the push notification',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
    'sections' => [
        'page' => [
            'title' => 'Push Notification Sending Test',
            'description' => 'Use this form to test sending push notifications to mobile devices through different services.',
        ],
    ],
];
