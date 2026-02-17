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
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
