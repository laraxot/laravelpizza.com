<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Assenza Sigma',
        'plural' => 'Assenze Sigma',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 5,
        'icon' => 'heroicon-o-clipboard-document-list',
        'label' => 'Assenze Sigma',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'ente',
            'helper_text' => 'ente',
            'description' => 'ente',
        ],
        'cont' => [
            'label' => 'Contatore',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'matr',
            'helper_text' => 'matr',
            'description' => 'matr',
        ],
        'asztip' => [
            'label' => 'Tipo assenza',
            'placeholder' => 'asztip',
            'helper_text' => 'asztip',
            'description' => 'asztip',
        ],
        'aszcod' => [
            'label' => 'Codice assenza',
            'placeholder' => 'aszcod',
            'helper_text' => 'aszcod',
            'description' => 'aszcod',
        ],
        'identificativi' => [
            'label' => 'Identificativi assenza',
        ],
        'ricerca' => [
            'label' => 'Ricerca assenze',
        ],
        'aszdal' => [
            'label' => 'Validità da',
        ],
        'aszal' => [
            'label' => 'Validità a',
        ],
        'aszini' => [
            'label' => 'Inizio',
        ],
        'aszfin' => [
            'label' => 'Fine',
        ],
        'aszumi' => [
            'label' => 'Unità misura',
        ],
        'aszpes' => [
            'label' => 'Peso',
        ],
        'aszdur' => [
            'label' => 'Durata',
        ],
        'aszann' => [
            'label' => 'Anno riferimento',
        ],
        'asz2kd' => [
            'label' => 'Data inizio',
        ],
        'asz2ka' => [
            'label' => 'Data fine',
        ],
        'value' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore',
        ],
    ],
    'label' => 'assenza sigma',
    'widgets' => [
        'stats' => [
            'total_count' => [
                'label' => 'Record attivi',
                'description' => 'Assenze Sigma con aszann vuoto (non annullate)',
            ],
            'lowest_asz2kd' => [
                'label' => '10 asz2kd più bassi',
                'description' => 'Date inizio (YYYYMMDD) — valori distinti più bassi',
            ],
            'highest_asz2ka' => [
                'label' => '10 asz2ka più alti',
                'description' => 'Date fine (YYYYMMDD) — valori distinti più alti',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
        ],
    ],
];
