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
<<<<<<< .merge_file_bb1MEe
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
            'tooltip' => '',
=======
            'tooltip' => '',
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
>>>>>>> .merge_file_apWD4q
            'placeholder' => 'team_id',
            'description' => 'team_id',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Collega',
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
    'label' => 'Assegna un ruolo',
    'plural_label' => 'Assegna un ruolo',
];
