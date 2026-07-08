<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'temporary upload',
        'group' => 'temporary upload',
        'icon' => 'temporary upload',
        'sort' => 96,
    ],
    'label' => 'Temporary Upload',
    'plural_label' => 'Temporary Upload (Plurale)',
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
            'label' => 'Crea Temporary Upload',
        ],
        'edit' => [
            'label' => 'Modifica Temporary Upload',
        ],
        'delete' => [
            'label' => 'Elimina Temporary Upload',
        ],
    ],
];
