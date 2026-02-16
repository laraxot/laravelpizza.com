<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Tenant',
        'plural' => 'Tenants',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei tenant e delle loro configurazioni',
        ],
        'label' => 'tenant',
        'sort' => '30',
        'icon' => 'user-user-tenant',
    ],
    'table' => [
        'heading' => 'Tenant',
    ],
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'secondary_color' => [
            'label' => 'secondary_color',
        ],
        'slug' => [
            'label' => 'slug',
        ],
        'name' => [
            'label' => 'name',
        ],
        'id' => [
            'label' => 'id',
        ],
        'message' => [
            'label' => 'message',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
        'change_password' => 'Cambio password',
    ],
];
