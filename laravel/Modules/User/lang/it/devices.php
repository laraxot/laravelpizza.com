<?php

declare(strict_types=1);

return [
    'fields' => [
        'login_at' => [
            'label' => 'login_at',
        ],
        'logout_at' => [
            'label' => 'logout_at',
        ],
    ],
    'navigation' => [
        'name' => 'Devices',
        'plural' => 'Devices',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Devices',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Devices',
    'plural_label' => 'Devices (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Devices',
        ],
        'edit' => [
            'label' => 'Modifica Devices',
        ],
        'delete' => [
            'label' => 'Elimina Devices',
        ],
    ],
];
