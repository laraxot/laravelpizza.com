<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Dirigenti di stabilimento',
    ],
    'navigation' => [
        'name' => 'Dirigenti di stabilimento',
        'plural' => 'Dirigenti di stabilimento',
        'group' => [
            'name' => 'Organizzazione',
        ],
        'label' => 'Dirigenti di stabilimento',
        'sort' => 85,
        'icon' => 'heroicon-o-building-office-2',
    ],
    'fields' => [
        'brand' => 'Marca',
        'model' => 'Modello',
        'description' => 'Descrizione',
        'serial_number' => 'Numero di serie',
        'inventory_number' => 'Codice inventario',
        'code' => 'Identificativo',
        'manufacturing_year' => 'Anno di fabbricazione',
        'purchase_year' => 'Anno di acquisto',
        'is_enabled' => 'È attivo?',
        'asset_type' => 'Tipologia',
        'area' => 'Area',
        'parent' => 'Asset genitore',
        'name' => 'Nome',
        'id' => [
            'label' => 'ID',
            'description' => 'id',
            'helper_text' => 'id',
            'placeholder' => 'id',
        ],
        'valutatore_id' => [
            'label' => 'Valutatore Id',
            'description' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
        ],
        'stabi' => [
            'label' => 'Stabi',
            'description' => 'stabi',
            'helper_text' => 'stabi',
            'placeholder' => 'stabi',
        ],
        'repar' => [
            'label' => 'Repar',
            'description' => 'repar',
            'helper_text' => 'repar',
            'placeholder' => 'repar',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'anno',
            'helper_text' => 'anno',
            'description' => 'anno',
        ],
        'matr' => [
            'label' => 'Matricola',
            'description' => 'matr',
            'helper_text' => 'matr',
            'placeholder' => 'matr',
        ],
        'cognome' => [
            'label' => 'Cognome',
        ],
        'nome' => [
            'label' => 'Nome',
        ],
        'nome_stabi' => [
            'label' => 'Nome Stabi',
            'description' => 'nome_stabi',
            'helper_text' => 'nome_stabi',
            'placeholder' => 'nome_stabi',
        ],
        'nome_diri' => [
            'label' => 'Nome diri',
            'description' => 'nome_diri',
            'helper_text' => 'nome_diri',
            'placeholder' => 'nome_diri',
        ],
        'nome_diri_plus' => [
            'label' => 'Nome diri Plus',
            'description' => 'nome_diri_plus',
            'helper_text' => 'nome_diri_plus',
            'placeholder' => 'nome_diri_plus',
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
        'email' => [
            'label' => 'email',
            'description' => 'email',
            'helper_text' => 'email',
            'placeholder' => 'email',
        ],
        'create' => [
            'label' => 'create',
        ],
        'value' => [
            'label' => 'value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'quadrimestre' => [
            'description' => 'quadrimestre',
            'helper_text' => 'quadrimestre',
            'placeholder' => 'quadrimestre',
            'label' => 'quadrimestre',
        ],
    ],
    'actions' => [
        'enable' => [
            'cta' => 'Attiva',
        ],
        'disable' => [
            'cta' => 'Dismetti',
        ],
        'import' => [
            'row_number' => 'Riga :row',
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Lista asset al',
            'columns' => [
                'brand' => 'Marca',
                'model' => 'Modello',
                'description' => 'Descrizione',
                'serial_number' => 'Numero di serie',
                'inventory_number' => 'Codice inventario',
                'code' => 'Identificativo',
                'manufacturing_year' => 'Anno di fabbricazione',
                'purchase_year' => 'Anno di acquisto',
                'is_enabled' => 'È attivo?',
                'asset_type' => 'Tipologia',
                'parent_inventory_number' => 'Codice inventario genitore',
            ],
        ],
        'create' => [
            'label' => 'create',
            'tooltip' => 'create',
            'icon' => 'create',
        ],
        'import_valutatori_' => [
            'label' => 'import_valutatori_',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
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
            'icon' => 'view',
            'label' => 'view',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
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
    ],
    'widgets' => [
        'child_assets' => 'Asset figli',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Dato obbligatorio non presente|{2} 2 Dati obbligatori non presenti|{3} 3 Dati obbligatori non presenti|[4,*] Vari dati obbligatori non presenti',
    ],
    'model' => [
        'label' => 'stabi dirigente.model',
    ],
    'label' => 'stabi dirigente',
];
