<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Test',
        'group' => 'Sviluppo',
        'icon' => 'heroicon-o-beaker',
        'sort' => 999,
    ],
    'label' => 'Test',
    'plural_label' => 'Test (Plurale)',
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
            'label' => 'Crea Test',
        ],
        'edit' => [
            'label' => 'Modifica Test',
        ],
        'delete' => [
            'label' => 'Elimina Test',
        ],
    ],
];
