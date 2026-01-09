<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Usuario del inquilino',
        'group' => 'Inquilino',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 39,
    ],
    'label' => 'Usuario del inquilino',
    'plural_label' => 'Usuarios del inquilino',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'user_id' => [
            'label' => 'Usuario',
        ],
        'tenant_id' => [
            'label' => 'Inquilino',
        ],
        'role' => [
            'label' => 'Rol',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
        'updated_at' => [
            'label' => 'Actualizado en',
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
