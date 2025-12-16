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
        'sort' => '92',
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
];
