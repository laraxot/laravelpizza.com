<?php

declare(strict_types=1);

return [
    'fill_out_the_form' => 'compila',
    'resource' => [
        'name' => 'Azione',
    ],
    'navigation' => [
        'name' => 'Azione',
        'plural' => 'Azioni',
        'group' => [
            'name' => 'Admin',
        ],
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
    ],
    'actions' => [
        'compila' => [
            'label' => 'Compila',
        ],
        'copy_from_last_year' => 'Copia dall\'anno precedente',
        'merge_double_row_cateco_year' => 'Unisci doppie righe Cateco per anno',
        'populate_year' => 'Popola anno',
        'trova_esclusi' => [
            'label' => 'Trova esclusi',
        ],
        'fill_out_the_form' => 'Compila',
        'showing_records' => 'Visualizzazione :count di :total record',
        'showing_limited_results' => 'Mostrati solo i primi 50 record. Modifica i filtri per restringere i risultati.',
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
        'delete_cessati' => [
            'label' => 'Cancella Cessati',
            'selection_title' => 'Selezione Anno',
            'selection_description' => 'Seleziona l\'anno per trovare i record presenti in Indennità Responsabilità ma non in Rep00f',
            'year_label' => 'Anno',
            'year_placeholder' => 'Seleziona un anno',
            'records_title' => 'Record da Cancellare',
            'records_description' => 'Questi record verranno cancellati permanentemente',
            'count_label' => 'Record trovati',
            'preview_label' => 'Anteprima record',
            'select_year' => 'Seleziona un anno',
            'records_found' => ':count record trovati',
            'no_records_found' => 'Nessun record trovato',
            'more_records' => 'e altri :count record...',
            'modal_title' => 'Cancella Record Cessati',
            'modal_heading' => 'Cancella Record Cessati',
            'modal_description' => 'Cancella i record presenti in Indennità Responsabilità ma non in Rep00f per l\'anno selezionato',
            'confirm_delete' => 'Cancella Record',
            'submit_label' => 'Cancella Record',
            'cancel' => 'Annulla',
            'cancel_label' => 'Annulla',
            'no_records_error' => 'Nessun record trovato per l\'anno selezionato',
            'no_year_error' => 'Seleziona un anno',
            'success_title' => 'Record Cancellati con Successo',
            'success_message' => ':count record sono stati cancellati',
            'no_records_title' => 'Nessun Record da Cancellare',
            'no_records_message' => 'Nessun record trovato per l\'anno selezionato',
            'error_title' => 'Errore di Cancellazione',
            'error_message' => 'Si è verificato un errore: :error',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Asset figli',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Dato obbligatorio non presente|{2} 2 Dati obbligatori non presenti|{3} 3 Dati obbligatori non presenti|[4,*] Vari dati obbligatori non presenti',
    ],
];
