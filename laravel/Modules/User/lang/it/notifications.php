<?php

declare(strict_types=1);

return [
    'password_changed_successfully' => [
        'title' => 'Password cambiata con successo!',
        'message' => 'La tua password è stata aggiornata.',
    ],
    'table_missing' => [
        'title' => 'Tabella Mancante',
        'body' => 'Tabella Mancante',
    ],
    'navigation' => [
        'name' => 'Notifications',
        'plural' => 'Notifications',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Notifications',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Notifications',
    'plural_label' => 'Notifications (Plurale)',
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
            'label' => 'Crea Notifications',
        ],
        'edit' => [
            'label' => 'Modifica Notifications',
        ],
        'delete' => [
            'label' => 'Elimina Notifications',
        ],
    ],
];
