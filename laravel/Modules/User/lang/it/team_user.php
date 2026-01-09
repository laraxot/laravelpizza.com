<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Membro del team',
        'group' => 'Team',
        'icon' => 'heroicon-o-users',
        'sort' => 38,
    ],
    'label' => 'Membro del team',
    'plural_label' => 'Membri del team',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utente',
        ],
        'team_id' => [
            'label' => 'Team',
        ],
        'role' => [
            'label' => 'Ruolo',
        ],
        'joined_at' => [
            'label' => 'Iscritto il',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Cambia ruolo',
        ],
        'remove_user' => [
            'label' => 'Rimuovi utente',
        ],
    ],
];