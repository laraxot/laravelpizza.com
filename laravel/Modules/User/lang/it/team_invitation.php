<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Invito al team',
        'group' => 'Team',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 37,
    ],
    'label' => 'Invito al team',
    'plural_label' => 'Inviti al team',
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
            'label' => 'Ruolo',
        ],
        'invited_by_id' => [
            'label' => 'Invitato da',
        ],
        'accepted_at' => [
            'label' => 'Accettato il',
        ],
        'expires_at' => [
            'label' => 'Scade il',
        ],
    ],
    'actions' => [
        'resend_invitation' => [
            'label' => 'Reinvia invito',
        ],
        'accept_invitation' => [
            'label' => 'Accetta invito',
        ],
        'cancel_invitation' => [
            'label' => 'Annulla invito',
        ],
    ],
];
