<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Client',
        'plural' => 'Clients',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei client e delle loro autorizzazioni',
        ],
        'label' => 'client',
        'sort' => 92,
        'icon' => 'user-user-client',
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
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'client.plural.model',
        ],
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyFilters' => [
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'delete' => [
            'icon' => 'delete',
            'label' => 'delete',
            'tooltip' => 'delete',
        ],
        'edit' => [
            'icon' => 'edit',
            'label' => 'edit',
            'tooltip' => 'edit',
        ],
        'create' => [
            'icon' => 'create',
            'label' => 'create',
            'tooltip' => 'create',
        ],
        'attach' => [
            'icon' => 'attach',
            'label' => 'attach',
            'tooltip' => 'attach',
        ],
        'detach' => [
            'icon' => 'detach',
            'label' => 'detach',
            'tooltip' => 'detach',
        ],
    ],
];
