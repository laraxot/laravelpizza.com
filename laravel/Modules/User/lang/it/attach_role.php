<?php

declare(strict_types=1);

<<<<<<< HEAD
// Finestra "Assegna un ruolo" (Utenti → modifica → Organizzazione → icona catena): AttachRoleAction.
return [
    'heading' => 'Assegna un ruolo',
    'fields' => [
        'recordId' => [
            'label' => 'Ruolo',
            'tooltip' => '',
        ],
        'team_id' => [
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
=======
return [
    'fields' => [
        'recordId' => [
            'tooltip' => '',
        ],
        'team_id' => [
>>>>>>> laraxot/dev
            'tooltip' => '',
            'label' => 'Team',
            'placeholder' => 'team_id',
            'helper_text' => 'team_id',
            'description' => 'team_id',
        ],
    ],
    'actions' => [
        'submit' => [
<<<<<<< HEAD
            'label' => 'Collega',
        ],
        'attachAnother' => [
            'label' => 'Collega e aggiungine un altro',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
    ],
    'label' => 'Assegna un ruolo',
    'plural_label' => 'Assegna un ruolo',
=======
            'icon' => 'submit',
        ],
        'attachAnother' => [
            'icon' => 'attachAnother',
        ],
        'cancel' => [
            'icon' => 'cancel',
        ],
    ],
    'navigation' => [
        'name' => 'Attach Role',
        'plural' => 'Attach Role',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Attach Role',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Attach Role',
    'plural_label' => 'Attach Role (Plurale)',
>>>>>>> laraxot/dev
];
