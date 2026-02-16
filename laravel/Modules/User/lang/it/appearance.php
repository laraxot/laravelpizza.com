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
