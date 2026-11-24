<?php

declare(strict_types=1);

// Finestra "Assegna un ruolo" (Utenti → modifica → Organizzazione → icona catena): AttachRoleAction.
return [
    'heading' => 'Rolle zuweisen',
    'fields' => [
        'recordId' => [
            'label' => 'Rolle',
            'tooltip' => '',
        ],
        'team_id' => [
            'label' => 'Team',
            'helper_text' => 'Optional: leer lassen, wenn die Rolle für die gesamte Website gilt.',
            'tooltip' => '',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Zuweisen',
        ],
        'attachAnother' => [
            'label' => 'Zuweisen und weitere hinzufügen',
        ],
        'cancel' => [
            'label' => 'Abbrechen',
        ],
    ],
    'label' => 'Rolle zuweisen',
    'plural_label' => 'Rolle zuweisen',
];
