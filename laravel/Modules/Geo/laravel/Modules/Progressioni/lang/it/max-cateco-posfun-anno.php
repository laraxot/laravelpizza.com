<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Massimo Categoria/PosFun per Anno',
        'plural' => 'Massimi Categoria/PosFun per Anno',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 23,
        'icon' => 'heroicon-o-chart-pie',
        'label' => 'Massimi Categoria/PosFun per Anno',
    ],
    'fields' => [
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona l\'anno di riferimento',
            'help' => 'Anno di riferimento per i massimi',
        ],
        'categoria' => [
            'label' => 'Categoria',
            'placeholder' => 'Seleziona la categoria professionale',
            'help' => 'Categoria professionale di riferimento',
        ],
        'posizione_funzionale' => [
            'label' => 'Posizione Funzionale',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Posizione funzionale di riferimento',
        ],
        'massimo' => [
            'label' => 'Massimo',
            'placeholder' => 'Inserisci il valore massimo',
            'help' => 'Valore massimo consentito per l\'anno specificato',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco del massimo',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data di creazione del massimo',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data di ultimo aggiornamento',
        ],
        'categoria_eco' => [
            'label' => 'Categoria Economica',
            'placeholder' => 'Seleziona la categoria economica',
            'help' => 'Categoria economica di riferimento',
        ],
        'posfun' => [
            'label' => 'PosFun',
            'placeholder' => 'Seleziona la posizione funzionale',
            'help' => 'Codice posizione funzionale',
        ],
        'valore_massimo' => [
            'label' => 'Valore Massimo',
            'placeholder' => 'Inserisci il valore massimo consentito',
            'help' => 'Valore massimo consentito per la combinazione categoria/posfun/anno',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sul massimo',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del massimo',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio validità',
            'help' => 'Data di inizio validità del massimo',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine validità',
            'help' => 'Data di fine validità del massimo',
        ],
        'motivo' => [
            'label' => 'Motivo',
            'placeholder' => 'Inserisci il motivo del massimo',
            'help' => 'Motivo della definizione del massimo',
        ],
        'approvato' => [
            'label' => 'Approvato',
            'help' => 'Indica se il massimo è stato approvato',
        ],
        'approvato_da' => [
            'label' => 'Approvato da',
            'placeholder' => 'Seleziona chi ha approvato',
            'help' => 'Utente che ha approvato il massimo',
        ],
        'data_approvazione' => [
            'label' => 'Data Approvazione',
            'help' => 'Data di approvazione del massimo',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Massimo',
            'success' => 'Massimo creato con successo',
            'error' => 'Errore durante la creazione del massimo',
        ],
        'edit' => [
            'label' => 'Modifica Massimo',
            'success' => 'Massimo aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del massimo',
        ],
        'delete' => [
            'label' => 'Elimina Massimo',
            'success' => 'Massimo eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del massimo',
            'confirmation' => 'Sei sicuro di voler eliminare questo massimo? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza Massimo',
        ],
        'approve' => [
            'label' => 'Approva Massimo',
            'success' => 'Massimo approvato con successo',
            'error' => 'Errore durante l\'approvazione del massimo',
            'confirmation' => 'Sei sicuro di voler approvare questo massimo?',
        ],
        'reject' => [
            'label' => 'Rifiuta Massimo',
            'success' => 'Massimo rifiutato con successo',
            'error' => 'Errore durante il rifiuto del massimo',
            'confirmation' => 'Sei sicuro di voler rifiutare questo massimo?',
        ],
        'import' => [
            'label' => 'Importa Massimi',
            'success' => 'Massimi importati con successo',
            'error' => 'Errore durante l\'importazione dei massimi',
            'confirmation' => 'Sei sicuro di voler importare questi massimi?',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta Massimi',
            'success' => 'Massimi esportati con successo',
            'error' => 'Errore durante l\'esportazione dei massimi',
            'filename_prefix' => 'Massimi_Categoria_PosFun_',
            'columns' => [
                'anno' => [
                    'label' => 'Anno',
                    'help' => 'Anno di riferimento',
                ],
                'categoria' => [
                    'label' => 'Categoria',
                    'help' => 'Categoria professionale',
                ],
                'posizione_funzionale' => [
                    'label' => 'Posizione Funzionale',
                    'help' => 'Posizione funzionale',
                ],
                'massimo' => [
                    'label' => 'Massimo',
                    'help' => 'Valore massimo consentito',
                ],
            ],
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i massimi',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo massimo',
        ],
    ],
    'messages' => [
        'created' => 'Massimo creato con successo',
        'updated' => 'Massimo aggiornato con successo',
        'deleted' => 'Massimo eliminato con successo',
        'approved' => 'Massimo approvato con successo',
        'rejected' => 'Massimo rifiutato con successo',
        'import_success' => 'Importazione massimi completata con successo',
        'export_success' => 'Esportazione massimi completata con successo',
        'validation_error' => 'Si sono verificati errori di validazione',
        'no_data' => 'Nessun massimo trovato',
        'loading' => 'Caricamento in corso...',
        'error' => 'Si è verificato un errore',
        'success' => 'Operazione completata con successo',
    ],
    'validation' => [
        'anno_required' => 'L\'anno è obbligatorio',
        'anno_numeric' => 'L\'anno deve essere un numero',
        'anno_min' => 'L\'anno deve essere almeno :min',
        'anno_max' => 'L\'anno non può essere maggiore di :max',
        'categoria_required' => 'La categoria è obbligatoria',
        'categoria_exists' => 'La categoria selezionata non è valida',
        'posizione_funzionale_required' => 'La posizione funzionale è obbligatoria',
        'posizione_funzionale_exists' => 'La posizione funzionale selezionata non è valida',
        'massimo_required' => 'Il massimo è obbligatorio',
        'massimo_numeric' => 'Il massimo deve essere numerico',
        'massimo_min' => 'Il massimo deve essere almeno :min',
        'massimo_max' => 'Il massimo non può essere maggiore di :max',
        'valore_massimo_required' => 'Il valore massimo è obbligatorio',
        'valore_massimo_numeric' => 'Il valore massimo deve essere numerico',
        'data_inizio_date' => 'La data di inizio deve essere una data valida',
        'data_fine_date' => 'La data di fine deve essere una data valida',
        'data_fine_after_inizio' => 'La data di fine deve essere successiva alla data di inizio',
        'unique_combination' => 'Esiste già un massimo per questa combinazione anno/categoria/posizione funzionale',
    ],
];
