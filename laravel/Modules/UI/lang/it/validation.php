<?php

declare(strict_types=1);

return [
    'opening_hours' => [
        'morning' => 'mattino',
        'afternoon' => 'pomeriggio',
        'morning_before_afternoon' => 'Per :day, l\'orario di chiusura del mattino deve essere precedente all\'apertura del pomeriggio.',
        'missing_closing_time' => 'Se specifichi l\'orario di apertura del :session per :day, devi specificare anche quello di chiusura.',
        'missing_opening_time' => 'Se specifichi l\'orario di chiusura del :session per :day, devi specificare anche quello di apertura.',
        'opening_before_closing' => 'L\'orario di apertura del :session per :day deve essere precedente a quello di chiusura.',
    ],
    'label' => 'Validation',
    'plural_label' => 'Validation (Plurale)',
    'navigation' => [
        'name' => 'Validation',
        'plural' => 'Validation',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Validation',
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
            'label' => 'Crea Validation',
        ],
        'edit' => [
            'label' => 'Modifica Validation',
        ],
        'delete' => [
            'label' => 'Elimina Validation',
        ],
    ],
];
