<?php

declare(strict_types=1);

return [
    'top-left' => [
        'label' => 'alto a sinistra',
    ],
    'top-right' => [
        'label' => 'alto a destra',
    ],
    'bottom-left' => [
        'label' => 'basso a sinistra',
    ],
    'bottom-right' => [
        'label' => 'basso a destra',
    ],
    'label' => 'Corner Position',
    'plural_label' => 'Corner Position (Plurale)',
    'navigation' => [
        'name' => 'Corner Position',
        'plural' => 'Corner Position',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Corner Position',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
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
            'label' => 'Crea Corner Position',
        ],
        'edit' => [
            'label' => 'Modifica Corner Position',
        ],
        'delete' => [
            'label' => 'Elimina Corner Position',
        ],
    ],
];
