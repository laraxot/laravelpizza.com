<?php

declare(strict_types=1);

return [
    'language_switcher' => [
        'select_language' => 'Seleziona lingua',
        'current_language' => 'Lingua corrente',
        'change_to' => 'Cambia a :language',
        'italian' => 'Italiano',
        'english' => 'Inglese',
        'german' => 'Tedesco',
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
