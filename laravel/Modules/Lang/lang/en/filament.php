<?php

return [
    'filters' => [
        'apply' => [
            'label' => 'Apply filters',
            'tooltip' => 'Apply the selected filters',
            'icon' => 'heroicon-o-funnel',
        ],
        'reset' => [
            'label' => 'Reset filters',
            'tooltip' => 'Restore default filters',
            'icon' => 'heroicon-o-x-mark',
        ],
        'open' => [
            'label' => 'Open filters',
            'tooltip' => 'Show the filter panels',
            'icon' => 'heroicon-o-adjustments-horizontal',
        ],
    ],
    'columns' => [
        'toggle' => [
            'label' => 'Show/Hide columns',
            'tooltip' => 'Manage column visibility',
            'icon' => 'heroicon-o-view-columns',
        ],
    ],
    'records' => [
        'reorder' => [
            'label' => 'Riordina record',
            'tooltip' => 'Change the order of records',
            'icon' => 'heroicon-o-arrows-up-down',
        ],
    ],
    'label' => 'Filament',
    'plural_label' => 'Filament (Plurale)',
    'navigation' => [
        'name' => 'Filament',
        'plural' => 'Filament',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Filament',
        'sort' => '1',
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identifier',
            'tooltip' => 'Unique record identifier',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Created at',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Last modified',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Create Filament',
        ],
        'edit' => [
            'label' => 'Edit Filament',
        ],
        'delete' => [
            'label' => 'Delete Filament',
        ],
    ],
];
