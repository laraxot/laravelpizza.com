<?php

declare(strict_types=1);

return [
    'failed' => 'Le credenziali non corrispondono a quelle registrate!',
    'general_error' => 'Non hai diritti sufficienti per questa operazione.',
    'socialite' => [
        'unacceptable' => ':provider non è supportato.',
    ],
    'throttle' => 'Troppi tentativi di login. Si prega di riprovare tra :seconds secondi.',
    'unknown' => 'Si è verificato un errore sconosciuto',
    'label' => 'Auth',
    'plural_label' => 'Auth (Plurale)',
    'navigation' => [
        'name' => 'Auth',
        'plural' => 'Auth',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Auth',
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
            'label' => 'Crea Auth',
        ],
        'edit' => [
            'label' => 'Modifica Auth',
        ],
        'delete' => [
            'label' => 'Elimina Auth',
        ],
    ],
];
