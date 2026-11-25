<?php

declare(strict_types=1);

return [
    'gg_in_sede_no_asz' => 'gg_in_sede_no_asz',
    'eta' => 'eta',
    'gg_cateco_posfun' => 'gg_cateco_posfun',
    'label' => 'Array Service',
    'plural_label' => 'Array Service (Plurale)',
    'navigation' => [
        'name' => 'Array Service',
        'plural' => 'Array Service',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Array Service',
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
            'label' => 'Crea Array Service',
        ],
        'edit' => [
            'label' => 'Modifica Array Service',
        ],
        'delete' => [
            'label' => 'Elimina Array Service',
        ],
    ],
];
