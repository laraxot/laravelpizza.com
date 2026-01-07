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
            'label' => 'Name',
        ],
        'user' => [
            'email' => [
                'label' => 'Owner',
            ],
        ],
        'create' => [
            'label' => 'Create',
        ],
        'edit' => [
            'label' => 'Edit',
        ],
        'delete' => [
            'label' => 'Delete',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
        ],
        'openFilters' => [
            'label' => 'Open Filters',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'client.plural.model',
        ],
    ],
];
