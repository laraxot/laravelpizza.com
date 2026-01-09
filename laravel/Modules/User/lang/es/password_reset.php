<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Restablecimiento de contraseña',
        'group' => 'Seguridad',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Restablecimiento de contraseña',
    'plural_label' => 'Restablecimientos de contraseña',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'token' => [
            'label' => 'Token',
        ],
        'created_at' => [
            'label' => 'Creado en',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Reenviar email',
        ],
        'view_request' => [
            'label' => 'Ver solicitud',
        ],
    ],
];