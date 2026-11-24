<?php

declare(strict_types=1);

// Finestra "Assegna un ruolo" (Utenti → modifica → Organizzazione → icona catena): AttachRoleAction.
return [
    'heading' => 'Assegna un ruolo',
    'fields' => [
        'recordId' => [
            'label' => 'Ruolo',
            'tooltip' => '',
        ],
        'team_id' => [
<<<<<<< HEAD
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
            'tooltip' => '',
=======
            'tooltip' => '',
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
            'placeholder' => 'team_id',
            'description' => 'team_id',
>>>>>>> laraxot/dev
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Collega',
<<<<<<< HEAD
        ],
        'attachAnother' => [
            'label' => 'Collega e aggiungine un altro',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
=======
            'icon' => 'submit',
        ],
        'attachAnother' => [
            'label' => 'Collega e aggiungine un altro',
            'icon' => 'attachAnother',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'icon' => 'cancel',
        ],
    ],
    'navigation' => [
        'name' => 'Assegna un ruolo',
        'plural' => 'Assegna un ruolo',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Assegna un ruolo',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
>>>>>>> laraxot/dev
    'label' => 'Assegna un ruolo',
    'plural_label' => 'Assegna un ruolo',
];
