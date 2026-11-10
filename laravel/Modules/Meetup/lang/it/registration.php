<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Iscritti',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-users',
        'sort' => 15,
    ],
    'label' => 'Iscrizione',
    'plural_label' => 'Iscritti',
    'fields' => [
        'user' => [
            'name' => [
                'label' => 'Nome',
                'placeholder' => '',
                'helper_text' => '',
                'description' => '',
                'tooltip' => '',
            ],
            'email' => [
                'label' => 'Email',
                'placeholder' => '',
                'helper_text' => '',
                'description' => '',
                'tooltip' => '',
            ],
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'attending' => 'Iscritto',
                'cancelled' => 'Annullata',
            ],
        ],
        'created_at' => [
            'label' => 'Iscritto il',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'export_csv' => [
            'label' => 'Scarica CSV',
            'tooltip' => 'Elenco degli iscritti per Excel',
        ],
        'cancel_registration' => [
            'label' => 'Annulla iscrizione',
            'tooltip' => 'Annulla iscrizione',
            'modal_heading' => 'Annullare questa iscrizione?',
            'modal_description' => 'Il posto torna disponibile. La persona non riceve un avviso automatico.',
            'notification' => 'Iscrizione annullata',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
    ],
];
