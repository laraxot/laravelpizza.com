<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Navigation Label',
        'group' => 'Geo',
    ],
    'label' => 'Location Map Table',
    'plural_label' => 'Location Map Table (Plurale)',
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
            'label' => 'Crea Location Map Table',
        ],
        'edit' => [
            'label' => 'Modifica Location Map Table',
        ],
        'delete' => [
            'label' => 'Elimina Location Map Table',
        ],
    ],
];
