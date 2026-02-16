<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Profilo Base',
    ],
    'navigation' => [
        'name' => 'Profilo',
        'plural' => 'Profili',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei profili',
        ],
        'label' => 'profili',
        'sort' => 31,
        'icon' => 'user-user-permission',
    ],
    'label' => 'Base Profile',
    'plural_label' => 'Base Profile (Plurale)',
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
            'label' => 'Crea Base Profile',
        ],
        'edit' => [
            'label' => 'Modifica Base Profile',
        ],
        'delete' => [
            'label' => 'Elimina Base Profile',
        ],
    ],
];
