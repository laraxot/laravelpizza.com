<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Miembro del equipo',
        'group' => 'Equipo',
        'icon' => 'heroicon-o-users',
        'sort' => 38,
    ],
    'label' => 'Miembro del equipo',
    'plural_label' => 'Miembros del equipo',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'team_id' => [
            'label' => 'Equipo',
        ],
        'role' => [
            'label' => 'Rol',
        ],
        'joined_at' => [
            'label' => 'Unido en',
        ],
    ],
    'actions' => [
        'change_role' => [
            'label' => 'Cambiar rol',
        ],
        'remove_user' => [
            'label' => 'Eliminar usuario',
        ],
    ],
];
