<?php

declare(strict_types=1);

return [
    'dark_mode_switcher' => [
        'toggle_aria_label' => 'Cambia tema',
        'toggle_title' => 'Clicca per cambiare tra tema chiaro e scuro',
        'light_mode' => 'Tema chiaro',
        'dark_mode' => 'Tema scuro',
    ],
    'label' => 'Widgets',
    'plural_label' => 'Widgets (Plurale)',
    'navigation' => [
        'name' => 'Widgets',
        'plural' => 'Widgets',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Widgets',
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
            'label' => 'Crea Widgets',
        ],
        'edit' => [
            'label' => 'Modifica Widgets',
        ],
        'delete' => [
            'label' => 'Elimina Widgets',
        ],
    ],
];
