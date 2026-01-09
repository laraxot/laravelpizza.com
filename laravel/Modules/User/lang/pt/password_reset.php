<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Redefinição de Senha',
        'group' => 'Segurança',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Redefinição de Senha',
    'plural_label' => 'Redefinições de Senha',
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
            'label' => 'Criado Em',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Reenviar Email',
        ],
        'view_request' => [
            'label' => 'Ver Solicitação',
        ],
    ],
];
