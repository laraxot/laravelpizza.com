<?php

declare(strict_types=1);

return [
    'previous' => '&laquo; Precedente',
    'next' => 'Successiva &raquo;',
    'label' => 'Pagination',
    'plural_label' => 'Pagination (Plurale)',
    'navigation' => [
        'name' => 'Pagination',
        'plural' => 'Pagination',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Pagination',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
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
            'label' => 'Crea Pagination',
        ],
        'edit' => [
            'label' => 'Modifica Pagination',
        ],
        'delete' => [
            'label' => 'Elimina Pagination',
        ],
    ],
];
