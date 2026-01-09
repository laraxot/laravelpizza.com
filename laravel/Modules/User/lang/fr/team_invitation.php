<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Invitation d\'équipe',
        'group' => 'Équipe',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 37,
    ],
    'label' => 'Invitation d\'équipe',
    'plural_label' => 'Invitations d\'équipe',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'team_id' => [
            'label' => 'Équipe',
        ],
        'role' => [
            'label' => 'Rôle',
        ],
        'invited_by_id' => [
            'label' => 'Invité par',
        ],
        'accepted_at' => [
            'label' => 'Accepté le',
        ],
        'expires_at' => [
            'label' => 'Expire le',
        ],
    ],
    'actions' => [
        'resend_invitation' => [
            'label' => 'Renvoyer l\'invitation',
        ],
        'accept_invitation' => [
            'label' => 'Accepter l\'invitation',
        ],
        'cancel_invitation' => [
            'label' => 'Annuler l\'invitation',
        ],
    ],
];