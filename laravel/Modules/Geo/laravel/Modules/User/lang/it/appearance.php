<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Aspetto',
        'plural' => 'Aspetto',
        'group' => [
            'name' => 'Aspetto',
            'description' => 'Personalizzazione dell\'aspetto del sistema',
        ],
        'label' => 'Aspetto',
        'icon' => 'heroicon-o-paint-brush',
        'sort' => 5,
    ],
    'label' => 'Appearance',
    'plural_label' => 'Appearance (Plurale)',
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
            'label' => 'Crea Appearance',
        ],
        'edit' => [
            'label' => 'Modifica Appearance',
        ],
        'delete' => [
            'label' => 'Elimina Appearance',
        ],
    ],
];
