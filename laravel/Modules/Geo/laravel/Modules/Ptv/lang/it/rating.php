<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Rating',
    ],
    'navigation' => [
        'name' => 'Rating',
        'plural' => 'Rating',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'brand' => ['label' => 'Marca'],
        'model' => ['label' => 'Modello'],
        'description' => ['label' => 'Descrizione'],
        'serial_number' => ['label' => 'Numero di serie'],
        'inventory_number' => ['label' => 'Codice inventario'],
        'code' => ['label' => 'Identificativo'],
        'manufacturing_year' => ['label' => 'Anno di fabbricazione'],
        'purchase_year' => ['label' => 'Anno di acquisto'],
        'is_enabled' => ['label' => 'È attivo?'],
        'asset_type' => ['label' => 'Tipologia'],
        'area' => ['label' => 'Area'],
        'parent' => ['label' => 'Asset genitore'],
        'name' => ['label' => 'Nome'],
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
    ],
    'widgets' => [
        'child_assets' => 'Asset figli',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Dato obbligatorio non presente|{2} 2 Dati obbligatori non presenti|{3} 3 Dati obbligatori non presenti|[4,*] Vari dati obbligatori non presenti',
    ],
];
