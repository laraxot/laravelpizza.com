<?php

declare(strict_types=1);

return [
    'label' => 'Contatti',
    'no_contacts' => 'Nessun contatto disponibile',
    'tooltip' => [
        'phone' => 'Clicca per chiamare',
        'mobile' => 'Clicca per chiamare',
        'email' => 'Clicca per inviare email',
        'pec' => 'Clicca per inviare PEC',
        'whatsapp' => 'Clicca per aprire WhatsApp',
        'fax' => 'Numero fax',
    ],
    'aria_labels' => [
        'contact_list' => 'Lista contatti',
        'contact_link' => 'Collegamento contatto',
        'no_contacts' => 'Nessun contatto disponibile',
    ],
    'plural_label' => 'Contact Column (Plurale)',
    'navigation' => [
        'name' => 'Contact Column',
        'plural' => 'Contact Column',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Contact Column',
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
            'label' => 'Crea Contact Column',
        ],
        'edit' => [
            'label' => 'Modifica Contact Column',
        ],
        'delete' => [
            'label' => 'Elimina Contact Column',
        ],
    ],
];
