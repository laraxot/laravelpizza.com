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
