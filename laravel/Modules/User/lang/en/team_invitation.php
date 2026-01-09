<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Team Invitation',
        'group' => 'Team',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 37,
    ],
    'label' => 'Team Invitation',
    'plural_label' => 'Team Invitations',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'team_id' => [
            'label' => 'Team',
        ],
        'role' => [
            'label' => 'Role',
        ],
        'invited_by_id' => [
            'label' => 'Invited By',
        ],
        'accepted_at' => [
            'label' => 'Accepted At',
        ],
        'expires_at' => [
            'label' => 'Expires At',
        ],
    ],
    'actions' => [
        'resend_invitation' => [
            'label' => 'Resend Invitation',
        ],
        'accept_invitation' => [
            'label' => 'Accept Invitation',
        ],
        'cancel_invitation' => [
            'label' => 'Cancel Invitation',
        ],
    ],
];
