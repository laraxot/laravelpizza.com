<?php

declare(strict_types=1);

// Finestra "Assegna un ruolo" (Utenti → modifica → Organizzazione → icona catena): AttachRoleAction.
return [
    'heading' => 'Assign a role',
    'fields' => [
        'recordId' => [
            'label' => 'Role',
            'tooltip' => '',
        ],
        'team_id' => [
            'label' => 'Team',
            'helper_text' => 'Optional: leave empty if the role applies to the whole site.',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Attach',
        ],
        'attachAnother' => [
            'label' => 'Attach and add another',
        ],
        'cancel' => [
            'label' => 'Cancel',
        ],
    ],
    'label' => 'Assign a role',
    'plural_label' => 'Assign a role',
];
