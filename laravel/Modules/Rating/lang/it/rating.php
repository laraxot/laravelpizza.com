<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => [
            'label' => 'Rating',
        ],
    ],
    'navigation' => [
        'name' => [
            'label' => 'Rating',
        ],
        'plural' => [
            'label' => 'Rating',
        ],
        'group' => [
            'name' => [
                'label' => 'Admin',
            ],
        ],
        'sort' => 33,
        'label' => 'Rating',
    ],
    'fields' => [
        'brand' => [
            'label' => 'Marca',
        ],
        'model' => [
            'label' => 'Modello',
        ],
        'description' => [
            'label' => 'Descrizione',
        ],
        'serial_number' => [
            'label' => 'Numero di serie',
        ],
        'inventory_number' => [
            'label' => 'Codice inventario',
        ],
        'code' => [
            'label' => 'Identificativo',
        ],
        'manufacturing_year' => [
            'label' => 'Anno di fabbricazione',
        ],
        'purchase_year' => [
            'label' => 'Anno di acquisto',
        ],
        'is_enabled' => [
            'label' => 'È attivo?',
        ],
        'asset_type' => [
            'label' => 'Tipologia',
        ],
        'area' => [
            'label' => 'Area',
        ],
        'parent' => [
            'label' => 'Asset genitore',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'is_disabled' => [
            'label' => 'is_disabled',
        ],
        'is_readonly' => [
            'label' => 'is_readonly',
        ],
        '_tpl' => [
            'label' => '_tpl',
        ],
        'ratings' => [
            'label' => 'ratings',
        ],
        'id' => [
            'label' => 'id',
        ],
        'title' => [
            'label' => 'title',
        ],
        'color' => [
            'label' => 'color',
        ],
        'rating' => [
            'label' => 'rating',
            'description' => 'rating',
            'helper_text' => 'rating',
        ],
        'view' => [
            'label' => 'view',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'type' => [
            'label' => 'type',
        ],
        'rule' => [
            'label' => 'rule',
        ],
    ],
    'actions' => [
        'enable' => [
            'cta' => [
                'label' => 'Attiva',
            ],
            'label' => [
                'label' => 'Attiva',
            ],
        ],
        'disable' => [
            'cta' => [
                'label' => 'Dismetti',
            ],
            'label' => [
                'label' => 'Dismetti',
            ],
        ],
        'import' => [
            'row_number' => [
                'label' => 'Riga :row',
            ],
            'label' => [
                'label' => 'Importa',
            ],
            'fields' => [
                'import_file' => [
                    'label' => 'Seleziona un file XLS o CSV da caricare',
                ],
            ],
        ],
        'export' => [
            'filename_prefix' => [
                'label' => 'Lista asset al',
            ],
            'label' => [
                'label' => 'Esporta',
            ],
            'columns' => [
                'brand' => [
                    'label' => 'Marca',
                ],
                'model' => [
                    'label' => 'Modello',
                ],
                'description' => [
                    'label' => 'Descrizione',
                ],
                'serial_number' => [
                    'label' => 'Numero di serie',
                ],
                'inventory_number' => [
                    'label' => 'Codice inventario',
                ],
                'code' => [
                    'label' => 'Identificativo',
                ],
                'manufacturing_year' => [
                    'label' => 'Anno di fabbricazione',
                ],
                'purchase_year' => [
                    'label' => 'Anno di acquisto',
                ],
                'is_enabled' => [
                    'label' => 'È attivo?',
                ],
                'asset_type' => [
                    'label' => 'Tipologia',
                ],
                'parent_inventory_number' => [
                    'label' => 'Codice inventario genitore',
                ],
            ],
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
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
            'icon' => 'createAnother',
            'label' => 'createAnother',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'save' => [
            'label' => 'save',
            'icon' => 'save',
            'tooltip' => 'save',
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
    ],
    'widgets' => [
        'child_assets' => [
            'label' => 'Asset figli',
        ],
    ],
    'exceptions' => [
        'mandatory_data' => [
            'label' => '{1} Dato obbligatorio non presente|{2} 2 Dati obbligatori non presenti|{3} 3 Dati obbligatori non presenti|[4,*] Vari dati obbligatori non presenti',
        ],
    ],
    'label' => 'rating',
];
