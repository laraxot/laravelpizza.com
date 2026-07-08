<?php

declare(strict_types=1);

return [
    'state_icons' => [
        'no_transitions' => 'Nessuna transizione disponibile',
    ],
    'label' => 'Components',
    'plural_label' => 'Components (Plurale)',
    'navigation' => [
        'name' => 'Components',
        'plural' => 'Components',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Components',
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
            'label' => 'Crea Components',
        ],
        'edit' => [
            'label' => 'Modifica Components',
        ],
        'delete' => [
            'label' => 'Elimina Components',
        ],
    ],
];
