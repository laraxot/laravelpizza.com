<?php

declare(strict_types=1);

return [
    'password' => 'Le password devono essere di almeno 6 caratteri e devono coincidere.',
    'reset' => 'La password è stata reimpostata!',
    'sent' => 'E-mail per il reset della password inviata!',
    'token' => 'Questo token per il reset della password non è valido.',
    'user' => 'Non esiste alcun utente associato a questo indirizzo e-mail.',
    'label' => 'Passwords',
    'plural_label' => 'Passwords (Plurale)',
    'navigation' => [
        'name' => 'Passwords',
        'plural' => 'Passwords',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Passwords',
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
            'label' => 'Crea Passwords',
        ],
        'edit' => [
            'label' => 'Modifica Passwords',
        ],
        'delete' => [
            'label' => 'Elimina Passwords',
        ],
    ],
];
