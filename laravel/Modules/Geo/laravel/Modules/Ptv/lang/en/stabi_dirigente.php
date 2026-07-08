<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Plant Managers',
    ],
    'navigation' => [
        'name' => 'Plant Managers',
        'plural' => 'Plant Managers',
        'group' => [
            'name' => 'Organization',
        ],
        'label' => 'Plant Managers',
        'sort' => 85,
        'icon' => 'heroicon-o-building-office-2',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'description' => 'id',
            'helper_text' => 'id',
            'placeholder' => 'id',
        ],
        'valutatore_id' => [
            'label' => 'Evaluator Id',
            'description' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
        ],
        'stabi' => [
            'label' => 'Plant Code',
            'description' => 'stabi',
            'helper_text' => 'stabi',
            'placeholder' => 'stabi',
        ],
        'repar' => [
            'label' => 'Department',
            'description' => 'repar',
            'helper_text' => 'repar',
            'placeholder' => 'repar',
        ],
        'anno' => [
            'label' => 'Year',
            'placeholder' => 'year',
            'helper_text' => 'year',
            'description' => 'year',
        ],
        'matr' => [
            'label' => 'Employee ID',
            'description' => 'matr',
            'helper_text' => 'matr',
            'placeholder' => 'matr',
        ],
        'cognome' => [
            'label' => 'Last Name',
        ],
        'nome' => [
            'label' => 'First Name',
        ],
        'nome_stabi' => [
            'label' => 'Plant Name',
            'description' => 'nome_stabi',
            'helper_text' => 'nome_stabi',
            'placeholder' => 'nome_stabi',
        ],
        'nome_diri' => [
            'label' => 'Manager Name',
            'description' => 'nome_diri',
            'helper_text' => 'nome_diri',
            'placeholder' => 'nome_diri',
        ],
        'nome_diri_plus' => [
            'label' => 'Manager Name Plus',
            'description' => 'nome_diri_plus',
            'helper_text' => 'nome_diri_plus',
            'placeholder' => 'nome_diri_plus',
        ],
        'email' => [
            'label' => 'Email',
            'description' => 'email',
            'helper_text' => 'email',
            'placeholder' => 'email',
        ],
        'quadrimestre' => [
            'description' => 'quarter',
            'helper_text' => 'quarter',
            'placeholder' => 'quarter',
            'label' => 'Quarter',
        ],
    ],
    'actions' => [
        'enable' => [
            'cta' => 'Enable',
        ],
        'disable' => [
            'cta' => 'Disable',
        ],
        'import' => [
            'row_number' => 'Row :row',
            'fields' => [
                'import_file' => 'Select an XLS or CSV file to upload',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Asset list as of',
        ],
        'create' => [
            'label' => 'Create',
            'tooltip' => 'Create',
        ],
        'delete' => [
            'tooltip' => 'Delete',
            'label' => 'Delete',
        ],
        'edit' => [
            'tooltip' => 'Edit',
            'label' => 'Edit',
        ],
        'view' => [
            'tooltip' => 'View',
            'label' => 'View',
        ],
        'cancel' => [
            'tooltip' => 'Cancel',
        ],
        'resetFilters' => [
            'tooltip' => 'Reset Filters',
            'label' => 'Reset Filters',
        ],
        'applyFilters' => [
            'tooltip' => 'Apply Filters',
            'label' => 'Apply Filters',
        ],
        'openFilters' => [
            'tooltip' => 'Open Filters',
            'label' => 'Open Filters',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Child assets',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Mandatory data not present|{2} 2 Mandatory data not present|{3} 3 Mandatory data not present|[4,*] Several mandatory data not present',
    ],
    'model' => [
        'label' => 'Plant Manager',
    ],
    'label' => 'Plant Manager',
];
