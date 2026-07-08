<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Valutatore',
        'plural' => 'Valutatori',
        'group' => [
            'name' => 'Gestione Progressioni',
            'description' => 'Gestione completa delle progressioni di carriera',
        ],
        'sort' => 7,
        'icon' => 'heroicon-o-user-group',
        'label' => 'Valutatori',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del valutatore',
            'help' => 'Nome completo del valutatore',
        ],
        'parent' => [
            'label' => 'Valutatore Superiore',
            'placeholder' => 'Seleziona il valutatore superiore',
            'help' => 'Valutatore di livello superiore',
        ],
        'parent_name' => [
            'label' => 'Nome Valutatore Superiore',
            'placeholder' => 'Nome del valutatore superiore',
            'help' => 'Nome del valutatore di livello superiore',
        ],
        'assets' => [
            'label' => 'Risorse',
            'placeholder' => 'Seleziona le risorse associate',
            'help' => 'Risorse associate al valutatore',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco del valutatore',
            'description' => 'id',
            'helper_text' => 'id',
            'placeholder' => 'id',
        ],
        'created_at' => [
            'label' => 'Creato il',
            'help' => 'Data di creazione del valutatore',
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'help' => 'Data di ultimo aggiornamento',
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email del valutatore',
            'help' => 'Indirizzo email del valutatore',
        ],
        'telefono' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono del valutatore',
        ],
        'qualifica' => [
            'label' => 'Qualifica',
            'placeholder' => 'Seleziona la qualifica',
            'help' => 'Qualifica professionale del valutatore',
        ],
        'stabilimento' => [
            'label' => 'Stabilimento',
            'placeholder' => 'Seleziona lo stabilimento',
            'help' => 'Stabilimento di appartenenza del valutatore',
        ],
        'reparto' => [
            'label' => 'Reparto',
            'placeholder' => 'Seleziona il reparto',
            'help' => 'Reparto di appartenenza del valutatore',
        ],
        'data_nominativa' => [
            'label' => 'Data di Nomina',
            'placeholder' => 'Seleziona la data di nomina',
            'help' => 'Data di nomina come valutatore',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del valutatore',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sul valutatore',
        ],
        'approvato' => [
            'label' => 'Approvato',
            'help' => 'Indica se il valutatore è stato approvato',
        ],
        'approvato_da' => [
            'label' => 'Approvato da',
            'placeholder' => 'Seleziona chi ha approvato',
            'help' => 'Utente che ha approvato il valutatore',
        ],
        'data_approvazione' => [
            'label' => 'Data Approvazione',
            'help' => 'Data di approvazione del valutatore',
        ],
        'livello' => [
            'label' => 'Livello',
            'placeholder' => 'Seleziona il livello',
            'help' => 'Livello gerarchico del valutatore',
        ],
        'specializzazione' => [
            'label' => 'Specializzazione',
            'placeholder' => 'Inserisci la specializzazione',
            'help' => 'Area di specializzazione del valutatore',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
            'label' => 'value',
        ],
        'valutatore_id' => [
            'description' => 'valutatore_id',
            'helper_text' => 'valutatore_id',
            'placeholder' => 'valutatore_id',
            'label' => 'valutatore_id',
        ],
        'budget' => [
            'description' => 'budget',
            'helper_text' => 'budget',
            'placeholder' => 'budget',
            'label' => 'budget',
        ],
        'nome_diri_plus' => [
            'description' => 'nome_diri_plus',
            'helper_text' => 'nome_diri_plus',
            'placeholder' => 'nome_diri_plus',
            'label' => 'nome_diri_plus',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'nome_diri' => [
            'description' => 'nome_diri',
            'helper_text' => 'nome_diri',
            'placeholder' => 'nome_diri',
            'label' => 'nome_diri',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'anno' => [
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
            'label' => 'anno',
        ],
        'create' => [
            'label' => 'create',
        ],
        'matr' => [
            'label' => 'matr',
            'description' => 'matr',
            'helper_text' => 'matr',
            'placeholder' => 'matr',
        ],
        'ente' => [
            'label' => 'ente',
            'description' => 'ente',
            'helper_text' => 'ente',
            'placeholder' => 'ente',
        ],
        'repar_txt' => [
            'label' => 'repar_txt',
            'description' => 'repar_txt',
            'helper_text' => 'repar_txt',
            'placeholder' => 'repar_txt',
        ],
        'stabi_txt' => [
            'label' => 'stabi_txt',
            'description' => 'stabi_txt',
            'helper_text' => 'stabi_txt',
            'placeholder' => 'stabi_txt',
        ],
        'nome_stabi' => [
            'label' => 'nome_stabi',
            'description' => 'nome_stabi',
            'helper_text' => 'nome_stabi',
            'placeholder' => 'nome_stabi',
        ],
        'repar' => [
            'label' => 'repar',
            'description' => 'repar',
            'helper_text' => 'repar',
            'placeholder' => 'repar',
        ],
        'stabi' => [
            'label' => 'stabi',
            'description' => 'stabi',
            'helper_text' => 'stabi',
            'placeholder' => 'stabi',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa da file',
            'success' => 'Valutatori importati con successo',
            'error' => 'Errore durante l\'importazione dei valutatori',
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
            'confirmation' => 'Sei sicuro di voler esportare i dati?',
            'filename_prefix' => 'Valutatori_',
            'columns' => [
                'name' => [
                    'label' => 'Nome valutatore',
                    'help' => 'Nome del valutatore',
                ],
                'parent_name' => [
                    'label' => 'Nome valutatore superiore',
                    'help' => 'Nome del valutatore di livello superiore',
                ],
            ],
        ],
        'create' => [
            'label' => 'Nuovo valutatore',
            'success' => 'Valutatore creato con successo',
            'error' => 'Errore durante la creazione del valutatore',
        ],
        'edit' => [
            'label' => 'Modifica valutatore',
            'success' => 'Valutatore aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del valutatore',
        ],
        'delete' => [
            'label' => 'Elimina valutatore',
            'success' => 'Valutatore eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del valutatore',
            'confirmation' => 'Sei sicuro di voler eliminare questo valutatore? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza valutatore',
        ],
        'approve' => [
            'label' => 'Approva valutatore',
            'success' => 'Valutatore approvato con successo',
            'error' => 'Errore durante l\'approvazione del valutatore',
            'confirmation' => 'Sei sicuro di voler approvare questo valutatore?',
        ],
        'reject' => [
            'label' => 'Rifiuta valutatore',
            'success' => 'Valutatore rifiutato con successo',
            'error' => 'Errore durante il rifiuto del valutatore',
            'confirmation' => 'Sei sicuro di voler rifiutare questo valutatore?',
        ],
        'assign' => [
            'label' => 'Assegna valutatore',
            'success' => 'Valutatore assegnato con successo',
            'error' => 'Errore durante l\'assegnazione del valutatore',
        ],
        'unassign' => [
            'label' => 'Rimuovi assegnazione',
            'success' => 'Assegnazione rimossa con successo',
            'error' => 'Errore durante la rimozione dell\'assegnazione',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
        ],
        'logout' => [
            'label' => 'logout',
            'tooltip' => 'logout',
            'icon' => 'logout',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'profile' => [
            'label' => 'profile',
        ],
    ],
    'tabs' => [
        'index' => [
            'label' => 'Lista',
            'description' => 'Visualizza tutti i valutatori',
        ],
        'create' => [
            'label' => 'Aggiungi',
            'description' => 'Crea un nuovo valutatore',
        ],
    ],
    'messages' => [
        'created' => 'Valutatore creato con successo',
        'updated' => 'Valutatore aggiornato con successo',
        'deleted' => 'Valutatore eliminato con successo',
        'approved' => 'Valutatore approvato con successo',
        'rejected' => 'Valutatore rifiutato con successo',
        'assigned' => 'Valutatore assegnato con successo',
        'unassigned' => 'Assegnazione rimossa con successo',
        'import_success' => 'Importazione completata con successo',
        'export_success' => 'Esportazione completata con successo',
        'no_data' => 'Nessun valutatore trovato',
        'loading' => 'Caricamento in corso...',
        'error' => 'Si è verificato un errore',
        'warning' => 'Attenzione',
        'info' => 'Informazione',
        'success' => 'Operazione completata con successo',
    ],
    'validation' => [
        'name_required' => 'Il nome del valutatore è obbligatorio',
        'name_unique' => 'Il nome del valutatore è già presente',
        'email_required' => 'L\'email è obbligatoria',
        'email_email' => 'L\'email deve essere un indirizzo valido',
        'email_unique' => 'L\'email deve essere unica',
        'telefono_required' => 'Il telefono è obbligatorio',
        'qualifica_required' => 'La qualifica è obbligatoria',
        'stabilimento_required' => 'Lo stabilimento è obbligatorio',
        'stabilimento_exists' => 'Lo stabilimento selezionato non è valido',
        'reparto_required' => 'Il reparto è obbligatorio',
        'reparto_exists' => 'Il reparto selezionato non è valido',
        'data_nominativa_required' => 'La data di nomina è obbligatoria',
        'data_nominativa_date' => 'La data di nomina deve essere una data valida',
        'stato_required' => 'Lo stato è obbligatorio',
        'livello_required' => 'Il livello è obbligatorio',
        'specializzazione_required' => 'La specializzazione è obbligatoria',
        'required' => 'Il campo :attribute è obbligatorio',
        'string' => 'Il campo :attribute deve essere una stringa',
        'max' => 'Il campo :attribute non può superare :max caratteri',
        'unique' => 'Il valore del campo :attribute è già presente',
    ],
    'model' => [
        'label' => 'Modello Valutatore',
        'placeholder' => 'Seleziona modello valutatore',
        'tooltip' => 'Modello dati per i valutatori',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire i soggetti che effettuano le valutazioni',
        'help' => 'Modello che definisce la struttura dati per i valutatori',
    ],
    'label' => 'valutatore',
];
