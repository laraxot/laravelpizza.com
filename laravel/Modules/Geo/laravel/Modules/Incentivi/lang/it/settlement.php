<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Liquidazione',
        'plural' => 'Liquidazioni',
        'group' => [
            'name' => 'Admin',
            'description' => 'Gestione delle liquidazioni incentivi',
        ],
        'label' => 'Liquidazioni',
        'sort' => 90,
        'icon' => 'incentivi-settlement',
    ],
    'fields' => [
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo',
            'help' => 'Importo della liquidazione',
            'description' => 'importo',
        ],
        'data' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona la data',
            'help' => 'Data della liquidazione',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale della liquidazione',
            'options' => [
                'bozza' => 'Bozza',
                'approvata' => 'Approvata',
                'pagata' => 'Pagata',
                'annullata' => 'Annullata',
            ],
        ],
        'dipendente' => [
            'label' => 'Dipendente',
            'placeholder' => 'Seleziona il dipendente',
            'help' => 'Dipendente beneficiario',
        ],
        'progetto' => [
            'label' => 'Progetto',
            'placeholder' => 'Seleziona il progetto',
            'help' => 'Progetto di riferimento',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sulla liquidazione',
        ],
        'documenti' => [
            'label' => 'Documenti',
            'placeholder' => 'Carica i documenti',
            'help' => 'Documenti relativi alla liquidazione',
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di creazione del record',
            ],
            'updated_at' => [
                'label' => 'Ultimo Aggiornamento',
                'help' => 'Data dell\'ultima modifica',
            ],
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
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'view' => [
            'label' => 'view',
        ],
        'create' => [
            'label' => 'create',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'tipologia' => [
            'label' => 'tipologia',
        ],
        'project' => [
            'nome' => [
                'label' => 'project.nome',
            ],
        ],
        'denominazione' => [
            'label' => 'denominazione',
        ],
        'layout' => [
            'label' => 'layout',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Liquidazione',
            'success' => 'Liquidazione creata con successo',
            'error' => 'Errore durante la creazione',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Liquidazione aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Liquidazione eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questa liquidazione?',
        ],
        'approve' => [
            'label' => 'Approva',
            'success' => 'Liquidazione approvata con successo',
            'error' => 'Errore durante l\'approvazione',
        ],
        'pay' => [
            'label' => 'Paga',
            'success' => 'Liquidazione pagata con successo',
            'error' => 'Errore durante il pagamento',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'success' => 'Liquidazione annullata con successo',
            'error' => 'Errore durante l\'annullamento',
        ],
        'logout' => [
            'icon' => 'logout',
            'tooltip' => 'logout',
            'label' => 'logout',
        ],
    ],
    'messages' => [
        'validation' => [
            'importo' => [
                'required' => 'L\'importo è obbligatorio',
                'numeric' => 'L\'importo deve essere numerico',
                'min' => 'L\'importo deve essere maggiore di zero',
            ],
            'data' => [
                'required' => 'La data è obbligatoria',
                'date' => 'La data deve essere valida',
            ],
            'dipendente' => [
                'required' => 'Il dipendente è obbligatorio',
                'exists' => 'Il dipendente selezionato non esiste',
            ],
        ],
        'errors' => [
            'insufficient_funds' => 'Fondi insufficienti per la liquidazione',
            'invalid_status' => 'Stato non valido per l\'operazione',
            'already_paid' => 'Liquidazione già pagata',
            'documents_missing' => 'Documenti obbligatori mancanti',
        ],
        'warnings' => [
            'high_amount' => 'Importo superiore alla media',
            'pending_approvals' => 'Approvazioni in sospeso',
            'payment_delayed' => 'Pagamento in ritardo',
        ],
        'info' => [
            'payment_scheduled' => 'Pagamento programmato per :date',
            'documents_ready' => 'Documenti pronti per l\'elaborazione',
            'approval_required' => 'Richiesta approvazione superiore',
        ],
    ],
    'label' => 'Liquidazione',
    'plural_label' => 'Liquidazioni',
];
