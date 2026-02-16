<?php

declare(strict_types=1);

return [
    'fields' => [
        'addresses' => [
            'label' => 'Indirizzi',
            'placeholder' => 'Seleziona o inserisci un indirizzo',
            'help' => 'Gestione degli indirizzi associati al record',
        ],
        'name' => [
            'label' => 'Nome Indirizzo',
            'placeholder' => 'Inserisci un nome identificativo',
            'help' => 'Nome descrittivo per identificare facilmente l\'indirizzo (es. Casa, Ufficio, Studio]',
        ],
        'is_primary' => [
            'label' => 'Indirizzo Principale',
            'placeholder' => 'Seleziona se questo è l\'indirizzo principale',
            'help' => 'Indica se questo è l\'indirizzo principale tra tutti quelli registrati',
        ],
    ],
    'label' => 'Addresses Field',
    'plural_label' => 'Addresses Field (Plurale)',
    'navigation' => [
        'name' => 'Addresses Field',
        'plural' => 'Addresses Field',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Addresses Field',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Addresses Field',
        ],
        'edit' => [
            'label' => 'Modifica Addresses Field',
        ],
        'delete' => [
            'label' => 'Elimina Addresses Field',
        ],
    ],
];
