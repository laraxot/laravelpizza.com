<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Authentication Logs',
        'group' => 'Authentication',
        'icon' => 'heroicon-o-shield-check',
        'sort' => 5,
    ],
    'actions' => [
        'reorderRecords' => [
            'icon' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
        ],
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
        'resetColumnManager' => [
            'icon' => 'resetColumnManager',
        ],
        'save' => [
            'icon' => 'save',
        ],
    ],
    'label' => 'Authentication Log',
    'plural_label' => 'Authentication Log (Plurale)',
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
];
