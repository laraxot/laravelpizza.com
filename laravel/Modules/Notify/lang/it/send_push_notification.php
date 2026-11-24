<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio Notifica Push',
    ],
    'navigation' => [
        'name' => 'Invio Notifica Push',
        'plural' => 'Invio Notifiche Push',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di notifiche push tramite Firebase',
        ],
        'label' => 'Invio Notifiche Push',
        'icon' => 'notify-push-animated',
        'sort' => 51,
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
                'notification' => 'Notifica',
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
            'description' => 'Dati in formato JSON da inviare con la notifica',
            'tooltip' => '',
            'helper_text' => '',
        ],
        'value' => [
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Notifica',
            'success' => 'Notifica push inviata con successo',
            'error' => 'Errore durante l\'invio della notifica push',
        ],
        'preview' => [
            'label' => 'Anteprima',
        ],
        'save' => [
            'icon' => 'save',
        ],
        'notificationFormActions' => [
            'icon' => 'notificationFormActions',
        ],
        'add' => [
            'icon' => 'add',
        ],
        'addBetween' => [
            'icon' => 'addBetween',
        ],
        'clone' => [
            'icon' => 'clone',
        ],
        'collapse' => [
            'icon' => 'collapse',
        ],
        'collapseAll' => [
            'icon' => 'collapseAll',
        ],
        'delete' => [
            'icon' => 'delete',
        ],
        'expand' => [
            'icon' => 'expand',
        ],
        'expandAll' => [
            'icon' => 'expandAll',
        ],
        'moveDown' => [
            'icon' => 'moveDown',
        ],
        'moveUp' => [
            'icon' => 'moveUp',
        ],
        'reorder' => [
            'icon' => 'reorder',
        ],
        'profile' => [
            'icon' => 'profile',
        ],
        'logout' => [
            'icon' => 'logout',
        ],
    ],
    'label' => 'Send Push Notification',
    'plural_label' => 'Send Push Notification (Plurale)',
    'sections' => [
        'page' => [
            'title' => 'Test Invio Notifiche Push',
            'description' => 'Utilizza questo form per testare l\'invio di notifiche push ai dispositivi mobili tramite diversi servizi.',
        ],
    ],
];
