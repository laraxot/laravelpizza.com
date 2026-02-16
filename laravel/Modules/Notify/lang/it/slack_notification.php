<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Slack Notification',
        'group' => 'Notifiche',
    ],
    'label' => 'Slack Notification',
    'plural_label' => 'Slack Notification (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Slack Notification',
        ],
        'edit' => [
            'label' => 'Modifica Slack Notification',
        ],
        'delete' => [
            'label' => 'Elimina Slack Notification',
        ],
    ],
];
