<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Liquidazione Progetto',
        'plural' => 'Liquidazioni Progetti',
        'group' => [
            'name' => 'Incentivi',
            'description' => 'Gestione delle liquidazioni per progetti',
        ],
        'label' => 'liquidazioni_progetti',
        'sort' => 22,
        'icon' => 'incentivi-project-settlements',
    ],
    'fields' => [
        'progetto' => [
            'label' => 'Progetto',
            'placeholder' => 'Seleziona il progetto',
            'help' => 'Progetto di riferimento',
        ],
        'importo_totale' => [
            'label' => 'Importo Totale',
            'placeholder' => 'Inserisci l\'importo totale',
            'help' => 'Importo totale della liquidazione',
        ],
        'stato_progetto' => [
            'label' => 'Stato Progetto',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del progetto',
            'options' => [
                'in_corso' => 'In Corso',
                'completato' => 'Completato',
                'sospeso' => 'Sospeso',
                'annullato' => 'Annullato',
            ],
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio del progetto',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine del progetto',
        ],
        'responsabile' => [
            'label' => 'Responsabile',
            'placeholder' => 'Seleziona il responsabile',
            'help' => 'Responsabile del progetto',
        ],
        'partecipanti' => [
            'label' => 'Partecipanti',
            'placeholder' => 'Seleziona i partecipanti',
            'help' => 'Dipendenti coinvolti nel progetto',
        ],
        'documenti' => [
            'label' => 'Documenti',
            'placeholder' => 'Carica i documenti',
            'help' => 'Documenti relativi alla liquidazione',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sulla liquidazione',
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
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'tipologia' => [
            'label' => 'tipologia',
        ],
        'denominazione' => [
            'label' => 'denominazione',
        ],
        'download' => [
            'label' => 'download',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'project' => [
            'nome' => [
                'label' => 'project.nome',
            ],
        ],
        'nuova-liquidazione-unica' => [
            'label' => 'nuova-liquidazione-unica',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'importo' => [
            'label' => 'importo',
        ],
    ],
    'actions' => [
        'calculate' => [
            'label' => 'Calcola Liquidazione',
            'success' => 'Liquidazione calcolata con successo',
            'error' => 'Errore durante il calcolo',
        ],
        'distribute' => [
            'label' => 'Distribuisci',
            'success' => 'Importi distribuiti con successo',
            'error' => 'Errore durante la distribuzione',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Liquidazione approvata con successo',
            'error' => 'Errore durante l\'approvazione',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'success' => 'Liquidazione rifiutata con successo',
            'error' => 'Errore durante il rifiuto',
        ],
        'export' => [
            'label' => 'Esporta Report',
            'success' => 'Report esportato con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
    ],
    'messages' => [
        'validation' => [
            'importo_totale' => [
                'required' => 'L\'importo totale è obbligatorio',
                'numeric' => 'L\'importo deve essere numerico',
                'min' => 'L\'importo deve essere maggiore di zero',
            ],
            'progetto' => [
                'required' => 'Il progetto è obbligatorio',
                'exists' => 'Il progetto selezionato non esiste',
            ],
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
        ],
        'errors' => [
            'project_incomplete' => 'Progetto non completato',
            'budget_exceeded' => 'Budget del progetto superato',
            'missing_participants' => 'Nessun partecipante assegnato',
            'invalid_distribution' => 'Distribuzione importi non valida',
        ],
        'warnings' => [
            'high_amount' => 'Importo totale superiore alla media',
            'pending_tasks' => 'Attività in sospeso',
            'deadline_approaching' => 'Scadenza progetto imminente',
        ],
        'info' => [
            'distribution_ready' => 'Pronto per la distribuzione',
            'approvals_pending' => 'In attesa di approvazioni',
            'documents_required' => 'Documenti richiesti per procedere',
        ],
    ],
    'title' => 'project settlements',
];
