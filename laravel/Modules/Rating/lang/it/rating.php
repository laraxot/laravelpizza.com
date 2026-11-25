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
        'group' => 'Opzioni di voto',
        'sort' => 33,
        'label' => 'Rating',
        'icon' => 'heroicon-o-star',
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
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
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
            'label' => 'Disattivato',
        ],
        'is_readonly' => [
            'label' => 'Sola lettura',
        ],
        '_tpl' => [
            'label' => ' tpl',
        ],
        'ratings' => [
            'label' => 'Opzioni',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'color' => [
            'label' => 'Colore',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'rating' => [
            'label' => 'Opzione',
            'description' => '',
            'helper_text' => '',
            'placeholder' => '',
        ],
        'view' => [
            'label' => 'Vista',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'anno' => [
            'label' => 'Anno',
        ],
        'type' => [
            'label' => 'Tipo',
        ],
        'rule' => [
            'label' => 'Regola',
        ],
        'disabled' => [
            'label' => 'Disattivato',
            'placeholder' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Indirizzo (slug)',
        ],
        'order_column' => [
            'label' => 'Ordine',
        ],
        'created_at' => [
            'label' => 'Creato il',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
        ],
        'pivot' => [
            'user' => [
                'name' => [
                    'label' => 'Nome',
                ],
            ],
        ],
        'value' => [
            'label' => 'Valore',
        ],
        'is_winner' => [
            'label' => 'Is winner',
        ],
        'reward' => [
            'label' => 'Reward',
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
            'tooltip' => '',
            'icon' => 'delete',
            'label' => 'Elimina',
        ],
        'edit' => [
            'tooltip' => '',
            'icon' => 'edit',
            'label' => 'Modifica',
        ],
        'create' => [
            'label' => 'Nuovo',
            'icon' => 'create',
            'tooltip' => '',
        ],
        'layout' => [
            'label' => 'Vista',
            'icon' => 'layout',
            'tooltip' => '',
        ],
        'view' => [
            'label' => 'Vista',
            'icon' => 'view',
            'tooltip' => '',
        ],
        'logout' => [
            'tooltip' => '',
            'icon' => 'logout',
            'label' => 'Esci',
        ],
        'cancel' => [
            'tooltip' => '',
            'icon' => 'cancel',
            'label' => 'Annulla',
        ],
        'createAnother' => [
            'tooltip' => '',
            'icon' => 'createAnother',
            'label' => 'Salva e crea un altro',
        ],
        'profile' => [
            'tooltip' => '',
            'icon' => 'profile',
            'label' => 'Profile',
        ],
        'save' => [
            'label' => 'Salva',
            'icon' => 'save',
            'tooltip' => '',
        ],
        'applyFilters' => [
            'label' => 'Applica filtri',
            'icon' => 'applyFilters',
            'tooltip' => '',
        ],
        'openFilters' => [
            'label' => 'Filtri',
            'icon' => 'openFilters',
            'tooltip' => '',
        ],
        'resetFilters' => [
            'label' => 'Azzera filtri',
            'icon' => 'resetFilters',
            'tooltip' => '',
        ],
        'applyTableColumnManager' => [
            'label' => 'Applica colonne',
            'icon' => 'applyTableColumnManager',
            'tooltip' => '',
        ],
        'openColumnManager' => [
            'label' => 'Scegli colonne',
            'icon' => 'openColumnManager',
            'tooltip' => '',
        ],
        'resetColumnManager' => [
            'label' => 'Ripristina colonne',
            'icon' => 'resetColumnManager',
            'tooltip' => '',
        ],
        'reorderRecords' => [
            'label' => 'Riordina',
            'icon' => 'reorderRecords',
            'tooltip' => '',
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
