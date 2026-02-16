<?php

declare(strict_types=1);

return [
    'general' => [
        'home' => 'Home',
        'logout' => 'Logout',
    ],
    'frontend' => [
        'dashboard' => 'Dashboard',
        'login' => 'Login',
        'macros' => 'Macro',
        'register' => 'Registrazione',
        'user' => [
            'account' => 'My Account',
            'administration' => 'Amministrazione',
            'change_password' => 'Cambio Password',
            'my_information' => 'Profilo',
            'profile' => 'Profile',
        ],
    ],
    'label' => 'Navs',
    'plural_label' => 'Navs (Plurale)',
    'navigation' => [
        'name' => 'Navs',
        'plural' => 'Navs',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Navs',
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
            'label' => 'Crea Navs',
        ],
        'edit' => [
            'label' => 'Modifica Navs',
        ],
        'delete' => [
            'label' => 'Elimina Navs',
        ],
    ],
];
