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
            'label' => 'Team',
            'helper_text' => 'Facoltativo: lascia vuoto se il ruolo vale per tutto il sito.',
            'tooltip' => '',
            'label' => 'Team',
            'placeholder' => 'team_id',
            'helper_text' => 'team_id',
            'description' => 'team_id',
        ],
    ],
    'actions' => [
        'submit' => [
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
];
