<?php

declare(strict_types=1);

return [
    'table' => [
        'heading' => 'Gruppi di lavoro',
    ],
    'fields' => [
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'denominazione' => [
            'label' => 'Denominazione',
            'description' => 'denominazione',
            'helper_text' => 'denominazione',
            'placeholder' => 'denominazione',
        ],
        'updated_at' => [
            'label' => 'updated_at',
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
        ],
        'employees' => [
            'cognome' => [
                'label' => 'employees.cognome',
            ],
        ],
        'replicate' => [
            'label' => 'replicate',
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
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'message' => [
            'label' => 'message',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'value' => [
            'label' => 'value',
        ],
        'layout' => [
            'label' => 'layout',
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
        'WorkgroupSeederAction' => [
            'label' => 'WorkgroupSeederAction',
            'tooltip' => 'WorkgroupSeederAction',
            'icon' => 'WorkgroupSeederAction',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'label' => 'profile',
            'tooltip' => 'profile',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
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
        'layout' => [
            'icon' => 'layout',
            'label' => 'layout',
            'tooltip' => 'layout',
        ],
        'openFilters' => [
            'icon' => 'openFilters',
            'label' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'delete' => [
            'icon' => 'ui-delete',
            'label' => 'delete',
            'tooltip' => 'delete',
        ],
        'replicate' => [
            'icon' => 'ui-replicate',
            'label' => 'replicate',
            'tooltip' => 'replicate',
        ],
        'edit' => [
            'icon' => 'ui-edit',
            'label' => 'edit',
            'tooltip' => 'edit',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'ui-cancel',
            'label' => 'cancel',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'ui-save',
            'label' => 'save',
        ],
        'view' => [
            'tooltip' => 'view',
            'icon' => 'view',
            'label' => 'view',
        ],
        'create' => [
            'tooltip' => 'create',
            'icon' => 'create',
            'label' => 'create',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
            'icon' => 'createAnother',
            'label' => 'createAnother',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
    ],
    'navigation' => [
        'label' => 'Gruppi di Lavoro',
        'group' => 'Admin',
        'icon' => 'incentivi-workgroup',
        'sort' => 56,
    ],
    'sections' => [
        'Informazioni' => [
            'heading' => 'Informazioni',
            'label' => 'Informazioni',
        ],
    ],
    'label' => 'Gruppo di Lavoro',
    'plural_label' => 'Gruppi di Lavoro',
];
