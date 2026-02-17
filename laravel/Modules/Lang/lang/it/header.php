<?php

declare(strict_types=1);

return [
    'cta' => 'Richiedi Consulenza',
    'dashboard' => 'Dashboard',
    'profile' => 'Profilo',
    'settings' => 'Impostazioni',
    'logout' => 'Esci',
    'login' => 'Accedi',
    'language' => 'Lingua',
    'label' => 'Header',
    'plural_label' => 'Header (Plurale)',
    'navigation' => [
        'name' => 'Header',
        'plural' => 'Header',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Header',
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
            'label' => 'Crea Header',
        ],
        'edit' => [
            'label' => 'Modifica Header',
        ],
        'delete' => [
            'label' => 'Elimina Header',
        ],
    ],
];
