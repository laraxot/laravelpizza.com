<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Invitación al equipo',
        'group' => 'Equipo',
        'icon' => 'heroicon-o-user-plus',
        'sort' => 37,
    ],
    'label' => 'Invitación al equipo',
    'plural_label' => 'Invitaciones al equipo',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'team_id' => [
            'label' => 'Equipo',
        ],
        'role' => [
            'label' => 'Rol',
        ],
        'invited_by_id' => [
            'label' => 'Invitado por',
        ],
        'accepted_at' => [
            'label' => 'Aceptado en',
        ],
        'expires_at' => [
            'label' => 'Expira en',
        ],
    ],
    'actions' => [
        'resend_invitation' => [
            'label' => 'Reenviar invitación',
        ],
        'accept_invitation' => [
            'label' => 'Aceptar invitación',
        ],
        'cancel_invitation' => [
            'label' => 'Cancelar invitación',
        ],
    ],
];