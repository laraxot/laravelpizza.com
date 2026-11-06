<?php

declare(strict_types=1);

return [
    'user_widget' => [
        'start_date' => [
            'label' => 'Fecha de inicio:',
        ],
        'end_date' => [
            'label' => 'Fecha de fin:',
        ],
    ],
    'edit_user' => [
        'title' => 'Editar perfil de usuario',
        'description' => 'Actualiza la información del perfil de usuario',
        'sections' => [
            'personal_info' => [
                'title' => 'Información personal',
            ],
            'preferences' => [
                'title' => 'Preferencias',
            ],
            'security' => [
                'title' => 'Seguridad',
            ],
            'admin_settings' => [
                'title' => 'Ajustes de administrador',
            ],
        ],
    ],
];
