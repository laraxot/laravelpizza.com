<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Token',
        'plural' => 'Tokens',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei token di accesso',
        ],
        'label' => 'token',
        'sort' => 29,
        'icon' => 'user-user-token',
    ],
    'fields' => [
        'name' => [
            'label' => 'name',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
    ],
];
