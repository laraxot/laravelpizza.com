<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Attività di Default',
        'plural' => 'Attività di Default',
        'group' => [
            'name' => 'Admin',
        ],
        'label' => 'Attività di Default',
        'icon' => 'incentivi-default-activity',
        'sort' => 28,
    ],
    'table' => [
        'heading' => 'Attività di Default',
    ],
    'fields' => [
        'nome' => [
            'label' => 'Nome',
        ],
        'tipo' => [
            'label' => 'Tipo',
        ],
        'stato' => [
            'label' => 'Stato',
        ],
        'quota_percentuale' => [
            'label' => 'Quota percentuale',
            'description' => 'quota_percentuale',
            'helper_text' => 'quota_percentuale',
            'placeholder' => 'quota_percentuale',
        ],
        'anno_competenza' => [
            'label' => 'Anno competenza',
            'description' => 'anno_competenza',
            'helper_text' => 'anno_competenza',
            'placeholder' => 'anno_competenza',
        ],
        'importo' => [
            'label' => 'Importo',
            'description' => 'importo',
            'helper_text' => 'importo',
            'placeholder' => 'importo',
        ],
        'liquidazione_fasi' => [
            'label' => 'Liquidazione fasi',
            'description' => 'liquidazione_fasi',
            'helper_text' => 'liquidazione_fasi',
            'placeholder' => 'liquidazione_fasi',
        ],
        'appartiene_a_liquidazione_a_fasi' => [
            'label' => 'Appartiene a liquidazione a fasi?',
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
        'view' => [
            'label' => 'view',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'create' => [
            'label' => 'create',
        ],
    ],
    'actions' => [
        'DefaultActivitiesSeederAction' => [
            'label' => 'DefaultActivitiesSeederAction',
            'icon' => 'DefaultActivitiesSeederAction',
            'tooltip' => 'DefaultActivitiesSeederAction',
        ],
        'logout' => [
            'icon' => 'logout',
            'tooltip' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'delete' => [
            'tooltip' => 'delete',
            'icon' => 'delete',
            'label' => 'delete',
        ],
        'edit' => [
            'tooltip' => 'edit',
            'icon' => 'edit',
            'label' => 'edit',
        ],
        'view' => [
            'tooltip' => 'view',
            'label' => 'view',
            'icon' => 'view',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'save',
            'label' => 'save',
        ],
    ],
    'label' => 'default activity',
];
