<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Reimpostazione password',
        'group' => 'Sicurezza',
        'icon' => 'heroicon-o-key',
        'sort' => 42,
    ],
    'label' => 'Reimpostazione password',
    'plural_label' => 'Reimpostazioni password',
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
            'label' => 'Creato il',
        ],
    ],
    'actions' => [
        'resend_email' => [
            'label' => 'Reinvia email',
        ],
        'view_request' => [
            'label' => 'Visualizza richiesta',
        ],
    ],
];