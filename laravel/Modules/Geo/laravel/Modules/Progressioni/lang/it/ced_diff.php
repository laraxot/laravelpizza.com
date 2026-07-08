<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'CED Differenza',
        'plural' => 'CED Differenze',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 16,
        'icon' => 'heroicon-o-document-duplicate',
        'label' => 'CED Differenze',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome della differenza CED',
            'help' => 'Nome identificativo della differenza CED',
        ],
        'parent' => [
            'label' => 'Elemento Padre',
            'placeholder' => 'Seleziona l\'elemento padre',
            'help' => 'Elemento di livello superiore nella gerarchia',
        ],
        'parent_name' => [
            'label' => 'Nome Elemento Padre',
            'placeholder' => 'Nome dell\'elemento padre',
            'help' => 'Nome dell\'elemento di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse collegate a questa differenza CED',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco della differenza CED',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data di creazione della differenza CED',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data di ultimo aggiornamento',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione della differenza CED',
            'help' => 'Descrizione dettagliata della differenza CED',
        ],
        'codice' => [
            'label' => 'Codice',
            'placeholder' => 'Inserisci il codice della differenza CED',
            'help' => 'Codice identificativo della differenza CED',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale della differenza CED',
        ],
        'valore' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore della differenza CED',
            'help' => 'Valore numerico della differenza CED',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di differenza CED',
            'help' => 'Tipo di differenza CED',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Inserisci l\'anno di riferimento',
            'help' => 'Anno di riferimento per la differenza CED',
            'description' => 'anno',
        ],
        'mese' => [
            'label' => 'Mese',
            'placeholder' => 'Seleziona il mese',
            'help' => 'Mese di riferimento per la differenza CED',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sulla differenza CED',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'File importato con successo',
            'error' => 'Errore durante l\'importazione del file',
            'confirmation' => 'Sei sicuro di voler importare questo file?',
            'fields' => [
                'import_file' => [
                    'label' => 'File da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'help' => 'Formati supportati: XLS, XLSX, CSV. Dimensione massima: 10MB',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta dati',
            'success' => 'Dati esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'filename_prefix' => 'Differenze_CED_',
            'columns' => [
                'name' => [
                    'label' => 'Nome differenza CED',
                    'help' => 'Nome della differenza CED',
                ],
                'parent_name' => [
                    'label' => 'Nome elemento padre',
                    'help' => 'Nome dell\'elemento di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuova differenza CED',
            'success' => 'Differenza CED creata con successo',
            'error' => 'Errore durante la creazione della differenza CED',
        ],
        'edit' => [
            'label' => 'Modifica differenza CED',
            'success' => 'Differenza CED aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della differenza CED',
        ],
        'delete' => [
            'label' => 'Elimina differenza CED',
            'success' => 'Differenza CED eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della differenza CED',
            'confirmation' => 'Sei sicuro di voler eliminare questa differenza CED? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza differenza CED',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutte le differenze CED',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea una nuova differenza CED',
        ],
    ],
    'messages' => [
        'created' => 'Differenza CED creata con successo',
        'updated' => 'Differenza CED aggiornata con successo',
        'deleted' => 'Differenza CED eliminata con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'no_data' => 'Nessuna differenza CED trovata',
        'loading' => 'Caricamento in corso...',
        'error' => 'Si è verificato un errore',
        'success' => 'Operazione completata con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome della differenza CED è obbligatorio',
        'name_unique' => 'Il nome della differenza CED è già presente',
        'codice_required' => 'Il codice è obbligatorio',
        'codice_unique' => 'Il codice deve essere unico',
        'valore_numeric' => 'Il valore deve essere numerico',
        'anno_required' => 'L\'anno è obbligatorio',
        'anno_numeric' => 'L\'anno deve essere un numero',
        'anno_min' => 'L\'anno deve essere almeno :min',
        'anno_max' => 'L\'anno non può essere maggiore di :max',
        'tipo_required' => 'Il tipo è obbligatorio',
        'stato_required' => 'Lo stato è obbligatorio',
    ],
    'model' => [
        'label' => 'Modello CED Differenze',
        'placeholder' => 'Seleziona modello CED differenze',
        'tooltip' => 'Modello dati per le differenze CED',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire le differenze nei codici CED (Classificazione Economica Dipendenti)',
        'help' => 'Modello che definisce la struttura dati per le differenze CED',
    ],
];
