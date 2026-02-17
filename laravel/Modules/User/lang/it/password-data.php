<?php

declare(strict_types=1);

return [
    'fields' => [
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'help' => 'La password deve essere di almeno 8 caratteri',
            'validation' => [
                'required' => 'La password è obbligatoria',
                'min' => 'La password deve essere di almeno 8 caratteri',
                'max' => 'La password non può superare i 255 caratteri',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'password_confirmation' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password',
            'help' => 'Reinserisci la password per confermare',
            'validation' => [
                'required' => 'La conferma della password è obbligatoria',
                'min' => 'La password deve essere di almeno 8 caratteri',
                'max' => 'La password non può superare i 255 caratteri',
                'same' => 'Le password non coincidono',
            ],
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'navigation' => [
        'name' => 'Password Data',
        'plural' => 'Password Data',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Password Data',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Password Data',
    'plural_label' => 'Password Data (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Password Data',
        ],
        'edit' => [
            'label' => 'Modifica Password Data',
        ],
        'delete' => [
            'label' => 'Elimina Password Data',
        ],
    ],
];
