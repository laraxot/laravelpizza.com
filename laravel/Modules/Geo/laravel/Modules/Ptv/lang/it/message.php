<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'message',
    ],
    'navigation' => [
        'name' => 'Messaggio',
        'plural' => 'Messaggi',
        'group' => [
            'name' => 'Admin',
            'description' => 'Amministrazione e configurazione',
        ],
        'sort' => 80,
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'label' => 'Messaggi',
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
        ],
        'parent_id' => [
            'label' => 'Padre ID',
            'placeholder' => 'parent_id',
            'helper_text' => 'parent_id',
            'description' => 'parent_id',
        ],
        'type' => [
            'label' => 'Tipo Messaggio',
            'placeholder' => 'Seleziona tipo di messaggio',
            'tooltip' => 'Categoria del messaggio',
            'helper_text' => 'Seleziona il tipo di messaggio dalla lista esistente o crea un nuovo tipo usando il pulsante +',
            'help' => 'Il tipo viene utilizzato per categorizzare e filtrare i messaggi nel sistema',
            'description' => 'type',
        ],
        'title' => [
            'label' => 'Titolo',
            'description' => 'title',
            'helper_text' => 'title',
            'placeholder' => 'title',
        ],
        'valutatore_id' => [
            'label' => 'Valutatore Id',
        ],
        'stabi' => [
            'label' => 'Stabi',
        ],
        'repar' => [
            'label' => 'Repar',
        ],
        'anno' => [
            'label' => 'Anno',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'matr' => [
            'label' => 'Matr',
        ],
        'txt' => [
            'description' => 'txt',
            'helper_text' => 'txt',
            'placeholder' => 'txt',
            'label' => 'txt',
        ],
        'new_type' => [
            'description' => 'new_type',
            'label' => 'new_type',
            'placeholder' => 'new_type',
            'helper_text' => 'new_type',
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
        'create_type' => [
            'label' => 'Crea Nuovo Tipo',
            'tooltip' => 'Aggiungi un nuovo tipo di messaggio',
            'modal' => [
                'heading' => 'Crea Nuovo Tipo Messaggio',
                'description' => 'Inserisci il nome del nuovo tipo di messaggio. Verrà automaticamente convertito in formato slug.',
                'confirm' => 'Crea Tipo',
                'cancel' => 'Annulla',
            ],
            'fields' => [
                'new_type' => [
                    'label' => 'Nome Tipo',
                    'placeholder' => 'es. Notifica Importante',
                    'tooltip' => 'Nome del nuovo tipo di messaggio',
                    'helper_text' => 'Inserisci il nome del tipo. Verrà convertito automaticamente in formato slug (es. "notifica_importante")',
                    'help' => 'Il nome verrà convertito in formato slug per la memorizzazione nel database',
                ],
            ],
            'messages' => [
                'success' => 'Nuovo tipo creato con successo',
                'error' => 'Errore durante la creazione del tipo',
            ],
        ],
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Asset figli',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Dato obbligatorio non presente|{2} 2 Dati obbligatori non presenti|{3} 3 Dati obbligatori non presenti|[4,*] Vari dati obbligatori non presenti',
    ],
];
