<?php

declare(strict_types=1);

return [
    'actions' => [
        'edit' => [
            'icon' => 'edit',
        ],
        'delete' => [
            'icon' => 'delete',
        ],
        'detach' => [
            'icon' => 'detach',
        ],
        'attach' => [
            'icon' => 'attach',
        ],
        'create' => [
            'icon' => 'create',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
        ],
    ],
    'fields' => [
        'client' => [
            'name' => [
                'label' => 'client.name',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Nome',
        ],
        'scopes' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Ambiti',
        ],
        'revoked' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Revocato',
        ],
        'created_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Creato il',
        ],
        'expires_at' => [
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
            'label' => 'Scade il',
        ],
    ],
    'navigation' => [
        'name' => 'Oauth Token',
        'plural' => 'Oauth Token',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Oauth Token',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'label' => 'Oauth Token',
    'plural_label' => 'Oauth Token (Plurale)',
];
