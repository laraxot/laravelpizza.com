<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Assenza Individuale',
        'plural' => 'Assenze Individuali',
        'group' => [
            'name' => 'Valutazione',
            'description' => 'Gestione delle assenze individuali',
        ],
        'label' => 'assenze',
        'sort' => 37,
        'icon' => 'performance-absence',
    ],
    'fields' => [
        'dipendente' => [
            'name' => [
                'label' => 'Nome Dipendente',
                'placeholder' => 'Seleziona il dipendente',
                'help' => 'Dipendente a cui si riferisce l\'assenza',
            ],
            'matricola' => [
                'label' => 'Matricola',
                'placeholder' => 'Inserisci la matricola',
                'help' => 'Codice identificativo del dipendente',
            ],
            'reparto' => [
                'label' => 'Reparto',
                'placeholder' => 'Seleziona il reparto',
                'help' => 'Reparto di appartenenza',
            ],
        ],
        'assenza' => [
            'tipo' => [
                'label' => 'Tipo Assenza',
                'placeholder' => 'Seleziona il tipo',
                'help' => 'Tipologia di assenza',
                'options' => [
                    'malattia' => 'Malattia',
                    'ferie' => 'Ferie',
                    'permesso' => 'Permesso',
                    'congedo' => 'Congedo',
                    'aspettativa' => 'Aspettativa',
                    'altro' => 'Altro',
                ],
            ],
            'sottotipo' => [
                'label' => 'Sottotipo',
                'placeholder' => 'Seleziona il sottotipo',
                'help' => 'Specificazione del tipo di assenza',
            ],
            'giustificativo' => [
                'label' => 'Giustificativo',
                'placeholder' => 'Seleziona il giustificativo',
                'help' => 'Documento giustificativo dell\'assenza',
            ],
        ],
        'periodo' => [
            'data_inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Data di inizio dell\'assenza',
            ],
            'data_fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Data di fine dell\'assenza',
            ],
            'giorni_totali' => [
                'label' => 'Giorni Totali',
                'help' => 'Numero totale di giorni di assenza',
            ],
            'giorni_lavorativi' => [
                'label' => 'Giorni Lavorativi',
                'help' => 'Numero di giorni lavorativi di assenza',
            ],
        ],
        'stato' => [
            'label' => 'Stato',
            'help' => 'Stato attuale dell\'assenza',
            'options' => [
                'richiesta' => 'Richiesta',
                'approvata' => 'Approvata',
                'rifiutata' => 'Rifiutata',
                'annullata' => 'Annullata',
                'in_corso' => 'In Corso',
                'conclusa' => 'Conclusa',
            ],
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sull\'assenza',
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di registrazione dell\'assenza',
            ],
            'updated_at' => [
                'label' => 'Ultimo Aggiornamento',
                'help' => 'Data dell\'ultima modifica',
            ],
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'tipo' => [
            'label' => 'tipo',
        ],
        'codice' => [
            'label' => 'codice',
        ],
        'descr' => [
            'label' => 'descr',
        ],
        'anno' => [
            'label' => 'anno',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'value' => [
            'label' => 'value',
            'placeholder' => 'value',
            'helper_text' => 'value',
            'description' => 'value',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'view' => [
            'label' => 'view',
        ],
        'deleted_by' => [
            'label' => 'deleted_by',
        ],
        'updated_by' => [
            'label' => 'updated_by',
        ],
        'created_by' => [
            'label' => 'created_by',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Assenza',
            'success' => 'Assenza registrata con successo',
            'error' => 'Errore durante la registrazione',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Assenza aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Assenza eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questa assenza?',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Assenza approvata con successo',
            'error' => 'Errore durante l\'approvazione',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'success' => 'Assenza rifiutata con successo',
            'error' => 'Errore durante il rifiuto',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
        ],
        'copy_from_last_year_' => [
            'label' => 'copy_from_last_year_',
            'icon' => 'copy_from_last_year_',
            'tooltip' => 'copy_from_last_year_',
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
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
        'copy_from_last_year' => [
            'label' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'tooltip' => 'copy_from_last_year',
        ],
        'check' => [
            'label' => 'check',
            'icon' => 'check',
            'tooltip' => 'check',
        ],
        'CheckCriterioEsclusioneBulkAction' => [
            'label' => 'CheckCriterioEsclusioneBulkAction',
            'icon' => 'CheckCriterioEsclusioneBulkAction',
            'tooltip' => 'CheckCriterioEsclusioneBulkAction',
        ],
        'cancel' => [
            'tooltip' => 'cancel',
            'icon' => 'cancel',
            'label' => 'cancel',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
        ],
        'removeAllFilters' => [
            'tooltip' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'label' => 'removeAllFilters',
        ],
    ],
    'messages' => [
        'validation' => [
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
            'tipo' => [
                'required' => 'Il tipo è obbligatorio',
                'in' => 'Il tipo selezionato non è valido',
            ],
            'giustificativo' => [
                'required_if' => 'Il giustificativo è obbligatorio per questo tipo di assenza',
                'file' => 'Il giustificativo deve essere un file',
            ],
        ],
        'errors' => [
            'overlap_dates' => 'Date sovrapposte con altre assenze',
            'insufficient_days' => 'Giorni disponibili insufficienti',
            'expired_request' => 'Richiesta scaduta',
            'invalid_status' => 'Stato non valido per l\'operazione',
        ],
        'warnings' => [
            'holiday_included' => 'Il periodo include giorni festivi',
            'long_absence' => 'Assenza di lunga durata',
            'frequent_absences' => 'Frequenza elevata di assenze',
        ],
        'info' => [
            'days_remaining' => 'Giorni rimanenti: :days',
            'approval_pending' => 'In attesa di approvazione',
            'automatic_approval' => 'Approvazione automatica applicata',
        ],
    ],
    'model' => [
        'label' => 'individuale assenze.model',
    ],
    'label' => 'individuale assenze',
];
