<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Restablecimiento de Contraseña',
        'group' => 'Seguridad',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Restablecimiento de Contraseña',
    'plural_label' => 'Restablecimientos de Contraseña',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Correo Electrónico',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'created_at' => [
            'label' => 'Creado En',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Reenviar Correo',
        ],
        'view_request' => [
            'label' => 'Ver Solicitud',
        ],
    ],
];
