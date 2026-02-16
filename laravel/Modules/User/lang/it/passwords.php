<?php

declare(strict_types=1);

return [
    'reset' => 'La tua password è stata reimpostata.',
    'sent' => 'Ti abbiamo inviato un’email con il link per reimpostare la password.',
    'throttled' => 'Attendi prima di riprovare.',
    'token' => 'Questo token per la reimpostazione della password non è valido.',
    'user' => 'Non riesco a trovare un utente con quell’indirizzo email.',
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
    'label' => 'Passwords',
    'plural_label' => 'Passwords (Plurale)',
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
