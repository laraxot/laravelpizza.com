<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dipendente Progetto',
        'plural' => 'Dipendenti Progetti',
        'group' => [
            'name' => 'Incentivi',
            'description' => 'Gestione dei dipendenti nei progetti',
        ],
        'label' => 'Dipendenti del Progetto',
        'sort' => 18,
        'icon' => 'incentivi-project-employees',
    ],
    'fields' => [
        'dipendente' => [
            'nome' => [
                'label' => 'Nome Dipendente',
                'placeholder' => 'Seleziona il dipendente',
                'help' => 'Nome del dipendente assegnato',
            ],
            'matricola' => [
                'label' => 'Matricola',
                'placeholder' => 'Inserisci la matricola',
                'help' => 'Codice identificativo del dipendente',
            ],
            'ruolo' => [
                'label' => 'Ruolo',
                'placeholder' => 'Seleziona il ruolo',
                'help' => 'Ruolo nel progetto',
                'options' => [
                    'responsabile' => 'Responsabile',
                    'coordinatore' => 'Coordinatore',
                    'tecnico' => 'Tecnico',
                    'collaboratore' => 'Collaboratore',
                ],
            ],
        ],
        'assegnazione' => [
            'data_inizio' => [
                'label' => 'Data Inizio',
                'placeholder' => 'Seleziona la data di inizio',
                'help' => 'Data di inizio assegnazione',
            ],
            'data_fine' => [
                'label' => 'Data Fine',
                'placeholder' => 'Seleziona la data di fine',
                'help' => 'Data di fine assegnazione',
            ],
            'percentuale' => [
                'label' => 'Percentuale Impegno',
                'placeholder' => 'Inserisci la percentuale',
                'help' => 'Percentuale di tempo dedicato al progetto',
            ],
        ],
        'competenze' => [
            'label' => 'Competenze',
            'placeholder' => 'Seleziona le competenze',
            'help' => 'Competenze richieste per il ruolo',
        ],
        'responsabilita' => [
            'label' => 'Responsabilità',
            'placeholder' => 'Inserisci le responsabilità',
            'help' => 'Responsabilità assegnate',
        ],
        'obiettivi' => [
            'label' => 'Obiettivi',
            'placeholder' => 'Inserisci gli obiettivi',
            'help' => 'Obiettivi individuali nel progetto',
        ],
        'valutazione' => [
            'punteggio' => [
                'label' => 'Punteggio',
                'placeholder' => 'Inserisci il punteggio',
                'help' => 'Valutazione delle performance',
            ],
            'commenti' => [
                'label' => 'Commenti',
                'placeholder' => 'Inserisci i commenti',
                'help' => 'Note sulla valutazione',
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
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'anno_competenza' => [
            'label' => 'Anno Competenza',
        ],
        'sum_total_row' => [
            'label' => 'Somma Riga Totale',
        ],
        'posizione_inail' => [
            'label' => 'Posizione Inail',
        ],
        'codice_fiscale' => [
            'label' => 'Codice Fiscale',
        ],
        'nome' => [
            'label' => 'Nome',
        ],
        'cognome' => [
            'label' => 'Cognome',
        ],
        'matricola' => [
            'label' => 'Matricola',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'create' => [
            'label' => 'create',
        ],
        'addGroupAction' => [
            'label' => 'addGroupAction',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'recordId' => [
            'description' => 'recordId',
            'helper_text' => 'recordId',
            'placeholder' => 'recordId',
            'label' => 'recordId',
        ],
        'associate' => [
            'label' => 'associate',
        ],
        'AttachGroupAction' => [
            'label' => 'AttachGroupAction',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'AttachSingleEmployeeAction' => [
            'label' => 'AttachSingleEmployeeAction',
        ],
    ],
    'actions' => [
        'assign' => [
            'label' => 'Assegna',
            'success' => 'Dipendente assegnato con successo',
            'error' => 'Errore durante l\'assegnazione',
        ],
        'remove' => [
            'label' => 'Rimuovi',
            'success' => 'Dipendente rimosso con successo',
            'error' => 'Errore durante la rimozione',
            'confirm' => 'Sei sicuro di voler rimuovere questo dipendente dal progetto?',
        ],
        'evaluate' => [
            'label' => 'Valuta',
            'success' => 'Valutazione salvata con successo',
            'error' => 'Errore durante la valutazione',
        ],
        'update_role' => [
            'label' => 'Aggiorna Ruolo',
            'success' => 'Ruolo aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del ruolo',
        ],
        'GeneratePDFProjectReportAction' => [
            'label' => 'Scarica Dispone Gruppo di Lavoro',
        ],
        'AddGroupAction' => [
            'label' => 'AddGroupAction',
        ],
        'addGroupAction' => [
            'label' => 'addGroupAction',
        ],
        'create' => [
            'label' => 'create',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'label' => 'profile',
            'icon' => 'profile',
            'tooltip' => 'profile',
        ],
        'detach' => [
            'label' => 'detach',
            'icon' => 'detach',
            'tooltip' => 'È possibile scollegare questo Dipendente dal Progetto solo se non è collegato ad alcuna Attività.',
        ],
        'AttachGroupAction' => [
            'label' => 'AttachGroupAction',
            'icon' => 'AttachGroupAction',
            'tooltip' => 'AttachGroupAction',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
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
        'AttachSingleEmployeeAction' => [
            'label' => 'AttachSingleEmployeeAction',
            'icon' => 'AttachSingleEmployeeAction',
            'tooltip' => 'AttachSingleEmployeeAction',
        ],
        'cancel' => [
            'label' => 'cancel',
            'tooltip' => 'cancel',
            'icon' => 'cancel',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
        'AttachEsternoAction' => [
            'tooltip' => 'AttachEsternoAction',
            'icon' => 'AttachEsternoAction',
            'label' => 'AttachEsternoAction',
        ],
    ],
    'messages' => [
        'validation' => [
            'dipendente' => [
                'required' => 'Il dipendente è obbligatorio',
                'exists' => 'Il dipendente selezionato non esiste',
                'unique' => 'Il dipendente è già assegnato al progetto',
            ],
            'ruolo' => [
                'required' => 'Il ruolo è obbligatorio',
                'in' => 'Il ruolo selezionato non è valido',
            ],
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
            'percentuale' => [
                'required' => 'La percentuale è obbligatoria',
                'numeric' => 'La percentuale deve essere numerica',
                'between' => 'La percentuale deve essere tra 0 e 100',
            ],
        ],
        'errors' => [
            'role_conflict' => 'Conflitto di ruolo rilevato',
            'overallocation' => 'Dipendente già allocato al 100%',
            'missing_skills' => 'Competenze richieste mancanti',
            'invalid_period' => 'Periodo non valido',
        ],
        'warnings' => [
            'high_workload' => 'Carico di lavoro elevato',
            'skill_mismatch' => 'Possibile disallineamento competenze',
            'evaluation_due' => 'Valutazione in scadenza',
        ],
        'info' => [
            'assignment_details' => 'Dettagli assegnazione aggiornati',
            'role_requirements' => 'Requisiti ruolo disponibili',
            'evaluation_period' => 'Periodo di valutazione: :period',
        ],
    ],
    'title' => 'Dipendenti',
];
