<?php

declare(strict_types=1);

return [
    'table' => [
        'heading' => 'Attività',
    ],
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'description' => 'nome',
            'helper_text' => 'nome',
            'placeholder' => 'nome',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'description' => 'tipo',
            'helper_text' => 'tipo',
            'placeholder' => 'tipo',
        ],
        'appartiene_a_liquidazione_a_fasi' => [
            'label' => 'Appartiene a liquidazione a fasi?',
        ],
        'liquidazione_fasi' => [
            'label' => 'Fasi di liquidazione',
        ],
        'quota_percentuale' => [
            'label' => 'Quota percentuale',
            'description' => 'quota_percentuale',
            'helper_text' => 'quota_percentuale',
            'placeholder' => 'quota_percentuale',
        ],
        'importo' => [
            'label' => 'Importo',
            'description' => 'importo',
            'helper_text' => 'importo',
            'placeholder' => 'importo',
        ],
        'anno_competenza' => [
            'label' => 'Anno competenza',
            'description' => 'anno_competenza',
            'helper_text' => 'anno_competenza',
            'placeholder' => 'anno_competenza',
        ],
        'project_id' => [
            'label' => 'ID Progetto',
            'description' => 'project_id',
            'helper_text' => 'project_id',
            'placeholder' => 'project_id',
        ],
        'employees' => [
            'cognome' => [
                'label' => 'Dipendenti',
            ],
        ],
        'project' => [
            'nome' => [
                'label' => 'Nome Progetto',
            ],
        ],
        'phase_id' => [
            'label' => 'phase_id',
            'description' => 'phase_id',
            'helper_text' => 'phase_id',
            'placeholder' => 'phase_id',
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
        'create' => [
            'label' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'navigation' => [
        'label' => 'Attività',
        'group' => 'Admin',
        'icon' => 'incentivi-activity',
        'sort' => 4,
    ],
    'model' => [
        'label' => 'Attività',
    ],
    'label' => 'Attività',
    'plural_label' => 'Attività',
    'actions' => [
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'cancel' => [
            'icon' => 'ui-cancel',
            'label' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'save' => [
            'tooltip' => 'save',
            'icon' => 'ui-save',
            'label' => 'save',
        ],
        'torna-alle-attivita' => [
            'tooltip' => 'torna-alle-attivita',
            'icon' => 'torna-alle-attivita',
            'label' => 'torna-alle-attivita',
        ],
        'delete' => [
            'tooltip' => 'delete',
            'icon' => 'ui-delete',
            'label' => 'delete',
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
        'edit' => [
            'tooltip' => 'edit',
            'icon' => 'edit',
            'label' => 'edit',
        ],
        'submit' => [
            'tooltip' => 'submit',
        ],
        'view' => [
            'tooltip' => 'view',
            'icon' => 'view',
            'label' => 'view',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'label' => 'layout',
            'icon' => 'layout',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
    ],
    'sections' => [
        'Informazioni' => [
            'heading' => 'Informazioni',
            'label' => 'Informazioni',
        ],
        'tipo' => [
            'heading' => 'tipo',
        ],
    ],
];
