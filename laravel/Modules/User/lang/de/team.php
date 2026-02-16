<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Team',
        'plural' => 'Teams',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei team e delle loro autorizzazioni',
        ],
        'label' => 'team',
        'sort' => '18',
        'icon' => 'user-team',
    ],
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'detach' => [
            'label' => 'detach',
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
        'create' => [
            'label' => 'create',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'users_count' => [
            'label' => 'users_count',
        ],
        'name' => [
            'label' => 'name',
        ],
        'recordId' => [
            'label' => 'recordId',
            'description' => 'recordId',
            'helper_text' => 'recordId',
            'placeholder' => 'recordId',
        ],
        'personal_team' => [
            'label' => 'personal_team',
        ],
        'role' => [
            'label' => 'role',
            'description' => 'role',
            'helper_text' => 'role',
            'placeholder' => 'role',
        ],
        'description' => [
            'description' => 'description',
            'helper_text' => 'description',
            'placeholder' => 'description',
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
        'create' => [
            'label' => 'create',
        ],
    ],
    'plural' => [
        'model' => [
            'label' => 'team.plural.model',
        ],
    ],
    'model' => [
        'label' => 'team.model',
    ],
];
