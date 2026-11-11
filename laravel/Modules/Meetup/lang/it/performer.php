<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Relatori',
        'group' => 'Meetups',
        'icon' => 'heroicon-o-microphone',
        'sort' => 13,
    ],
    'label' => 'Relatore',
    'plural_label' => 'Relatori',
    'fields' => [
        'name' => [
            'label' => 'Nome e cognome',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'type' => [
            'label' => 'Ruolo',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
            'options' => [
                'speaker' => 'Relatore',
                'host' => 'Presentatore',
                'moderator' => 'Moderatore',
            ],
        ],
        'company' => [
            'label' => 'Azienda',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => '',
            'helper_text' => 'Visibile solo agli organizzatori.',
            'description' => '',
            'tooltip' => '',
        ],
        'website' => [
            'label' => 'Sito web',
            'placeholder' => 'https://',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'github' => [
            'label' => 'GitHub',
            'placeholder' => 'nome utente',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'linkedin' => [
            'label' => 'LinkedIn',
            'placeholder' => 'https://linkedin.com/in/…',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'twitter' => [
            'label' => 'X / Twitter',
            'placeholder' => 'nome utente',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
        'bio' => [
            'label' => 'Biografia',
            'placeholder' => '',
            'helper_text' => 'Due o tre righe su chi è e di cosa parla.',
            'description' => '',
            'tooltip' => '',
        ],
        'events_count' => [
            'label' => 'Eventi',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'tooltip' => 'Nuovo',
            'label' => 'Nuovo',
            'icon' => 'create',
        ],
        'createAnother' => [
            'label' => 'createAnother',
            'icon' => 'createAnother',
            'tooltip' => 'createAnother',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'icon' => 'cancel',
            'tooltip' => 'Annulla',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'Esci',
            'icon' => 'logout',
            'tooltip' => 'Esci',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
        ],
    ],
];
