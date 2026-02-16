<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Impostazioni Notifiche',
        'group' => 'Notifiche',
    ],
    'label' => 'Setting',
    'plural_label' => 'Setting (Plurale)',
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
            'label' => 'Crea Setting',
        ],
        'edit' => [
            'label' => 'Modifica Setting',
        ],
        'delete' => [
            'label' => 'Elimina Setting',
        ],
    ],
];
