<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Mappa Posizioni',
        'group' => 'Geo',
    ],
    'label' => 'Location Map',
    'plural_label' => 'Location Map (Plurale)',
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
            'label' => 'Crea Location Map',
        ],
        'edit' => [
            'label' => 'Modifica Location Map',
        ],
        'delete' => [
            'label' => 'Elimina Location Map',
        ],
    ],
];
