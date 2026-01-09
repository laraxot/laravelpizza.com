<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Membre de l\'équipe',
        'group' => 'Équipe',
        'icon' => 'heroicon-o-users',
        'sort' => 38,
    ],
    'label' => 'Membre de l\'équipe',
    'plural_label' => 'Membres de l\'équipe',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Utilisateur',
        ],
        'team_id' => [
            'label' => 'Équipe',
        ],
        'role' => [
            'label' => 'Rôle',
        ],
        'joined_at' => [
            'label' => 'Rejoint le',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Changer le rôle',
        ],
        'remove_user' => [
            'label' => 'Supprimer l\'utilisateur',
        ],
    ],
];
