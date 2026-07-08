<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Fase',
        'plural' => 'Fasi',
        'group' => [
            'name' => 'Admin',
            'description' => 'Gestione delle fasi incentivi',
        ],
        'label' => 'Fasi',
        'sort' => 6,
        'icon' => 'incentivi-phase',
    ],
    'fields' => [
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
        'end_date' => [
            'label' => 'end_date',
            'description' => 'end_date',
            'helper_text' => 'end_date',
            'placeholder' => 'end_date',
        ],
        'start_date' => [
            'label' => 'start_date',
            'description' => 'start_date',
            'helper_text' => 'start_date',
            'placeholder' => 'start_date',
        ],
        'description' => [
            'label' => 'description',
            'description' => 'description',
            'helper_text' => 'description',
            'placeholder' => 'description',
        ],
        'name' => [
            'label' => 'name',
            'description' => 'name',
        ],
        'settlement' => [
            'name' => [
                'label' => 'settlement.name',
            ],
            'denominazione' => [
                'label' => 'settlement.denominazione',
            ],
        ],
        'value' => [
            'label' => 'value',
        ],
        'is_active' => [
            'label' => 'is_active',
        ],
        'message' => [
            'label' => 'message',
        ],
        'importo' => [
            'description' => 'importo',
            'helper_text' => 'importo',
            'placeholder' => 'importo',
            'label' => 'importo',
        ],
        'denominazione' => [
            'description' => 'denominazione',
            'helper_text' => 'denominazione',
            'placeholder' => 'denominazione',
            'label' => 'denominazione',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'model' => [
        'label' => 'phase.model',
    ],
    'label' => 'phase',
    'actions' => [
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
    ],
    'sections' => [
        'Liquidazione' => [
            'heading' => 'Liquidazione',
        ],
    ],
];
