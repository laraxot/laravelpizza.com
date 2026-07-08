<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Dipendente',
        'plural' => 'Dipendenti',
        'group' => [
            'name' => 'Admin',
            'description' => 'Gestione dei dipendenti e incentivi',
        ],
        'label' => 'Dipendenti',
        'sort' => 40,
        'icon' => 'incentivi-employee',
    ],
    'fields' => [
        'anagrafica' => [
            'nome' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome',
                'help' => 'Nome del dipendente',
            ],
            'cognome' => [
                'label' => 'Cognome',
                'placeholder' => 'Inserisci il cognome',
                'help' => 'Cognome del dipendente',
            ],
            'matricola' => [
                'label' => 'Matricola',
                'placeholder' => 'Inserisci la matricola',
                'help' => 'Codice identificativo del dipendente',
            ],
            'codice_fiscale' => [
                'label' => 'Codice Fiscale',
                'placeholder' => 'Inserisci il codice fiscale',
                'help' => 'Codice fiscale del dipendente',
            ],
            'data_nascita' => [
                'label' => 'Data di Nascita',
                'placeholder' => 'Seleziona la data',
                'help' => 'Data di nascita del dipendente',
            ],
        ],
        'contratto' => [
            'tipo' => [
                'label' => 'Tipo Contratto',
                'placeholder' => 'Seleziona il tipo',
                'help' => 'Tipologia di contratto',
                'options' => [
                    'indeterminato' => 'Tempo Indeterminato',
                    'determinato' => 'Tempo Determinato',
                    'apprendistato' => 'Apprendistato',
                    'collaborazione' => 'Collaborazione',
                ],
            ],
            'data_assunzione' => [
                'label' => 'Data Assunzione',
                'placeholder' => 'Seleziona la data',
                'help' => 'Data di assunzione',
            ],
            'data_cessazione' => [
                'label' => 'Data Cessazione',
                'placeholder' => 'Seleziona la data',
                'help' => 'Data di cessazione',
            ],
            'livello' => [
                'label' => 'Livello',
                'placeholder' => 'Seleziona il livello',
                'help' => 'Livello contrattuale',
            ],
        ],
        'organizzazione' => [
            'reparto' => [
                'label' => 'Reparto',
                'placeholder' => 'Seleziona il reparto',
                'help' => 'Reparto di appartenenza',
            ],
            'ruolo' => [
                'label' => 'Ruolo',
                'placeholder' => 'Seleziona il ruolo',
                'help' => 'Ruolo organizzativo',
            ],
            'responsabile' => [
                'label' => 'Responsabile',
                'placeholder' => 'Seleziona il responsabile',
                'help' => 'Responsabile diretto',
            ],
        ],
        'competenze' => [
            'label' => 'Competenze',
            'placeholder' => 'Seleziona le competenze',
            'help' => 'Competenze professionali',
        ],
        'documenti' => [
            'label' => 'Documenti',
            'placeholder' => 'Carica i documenti',
            'help' => 'Documenti del dipendente',
        ],
        'stato' => [
            'label' => 'Stato',
            'help' => 'Stato attuale del dipendente',
            'options' => [
                'attivo' => 'Attivo',
                'sospeso' => 'Sospeso',
                'cessato' => 'Cessato',
            ],
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'create' => [
            'label' => 'create',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'matricola' => [
            'label' => 'Matricola',
        ],
        'cognome' => [
            'label' => 'Cognome',
            'description' => 'cognome',
            'helper_text' => 'cognome',
            'placeholder' => 'cognome',
        ],
        'nome' => [
            'label' => 'Nome',
            'description' => 'nome',
            'helper_text' => 'nome',
            'placeholder' => 'nome',
        ],
        'tipologia' => [
            'label' => 'Tipologia',
            'description' => 'tipologia',
        ],
        'sesso' => [
            'label' => 'Sesso',
            'description' => 'sesso',
            'helper_text' => 'sesso',
            'placeholder' => 'sesso',
        ],
        'codice_fiscale' => [
            'label' => 'codice_fiscale',
        ],
        'posizione_inail' => [
            'label' => 'posizione_inail',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'value' => [
            'label' => 'value',
            'description' => 'value',
            'helper_text' => 'value',
            'placeholder' => 'value',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'detach' => [
            'label' => 'detach',
        ],
        'newConsulenteEsterno' => [
            'label' => 'newConsulenteEsterno',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'importo_attivita_dipendente' => [
            'label' => 'Importo attività dipendente',
            'description' => 'importo_attivita_dipendente',
            'helper_text' => 'importo_attivita_dipendente',
            'placeholder' => 'importo_attivita_dipendente',
        ],
        'percentuale_attivita_dipendente' => [
            'label' => 'Percentuale attività dipendente',
            'description' => 'percentuale_attivita_dipendente',
            'helper_text' => 'percentuale_attivita_dipendente',
            'placeholder' => 'percentuale_attivita_dipendente',
        ],
        'recordId' => [
            'label' => 'recordId',
            'description' => 'recordId',
            'helper_text' => 'recordId',
            'placeholder' => 'recordId',
        ],
        'attach' => [
            'label' => 'attach',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'tqu00f_desc2' => [
            'label' => 'Qualifica',
        ],
        'tqu00f_desc1' => [
            'label' => 'Posizione Economica',
        ],
        'tqu00f' => [
            'label' => 'Posizione Economica/Qualifica',
        ],
        'full_name' => [
            'label' => 'Lavoratore',
        ],
        'project_id' => [
            'description' => 'project_id',
            'helper_text' => 'project_id',
            'placeholder' => 'project_id',
            'label' => 'project_id',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Dipendente',
            'success' => 'Dipendente creato con successo',
            'error' => 'Errore durante la creazione',
            'tooltip' => 'create',
            'icon' => 'create',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Dipendente aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Dipendente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questo dipendente?',
            'tooltip' => 'delete',
            'icon' => 'delete',
        ],
        'suspend' => [
            'label' => 'Sospendi',
            'success' => 'Dipendente sospeso con successo',
            'error' => 'Errore durante la sospensione',
        ],
        'reactivate' => [
            'label' => 'Riattiva',
            'success' => 'Dipendente riattivato con successo',
            'error' => 'Errore durante la riattivazione',
        ],
        'terminate' => [
            'label' => 'Termina',
            'success' => 'Dipendente cessato con successo',
            'error' => 'Errore durante la cessazione',
        ],
        'Carica/Aggiorna Dipendenti' => [
            'label' => 'Carica/Aggiorna Dipendenti',
            'tooltip' => 'Carica/Aggiorna Dipendenti',
            'icon' => 'Carica/Aggiorna Dipendenti',
        ],
        'logout' => [
            'label' => 'logout',
            'icon' => 'logout',
            'tooltip' => 'logout',
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
        'cancel' => [
            'label' => 'cancel',
            'tooltip' => 'cancel',
            'icon' => 'cancel',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'detach' => [
            'label' => 'detach',
            'icon' => 'detach',
            'tooltip' => 'detach',
        ],
        'attach' => [
            'label' => 'attach',
            'icon' => 'attach',
            'tooltip' => 'attach',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'attachAnother' => [
            'label' => 'attachAnother',
            'icon' => 'attachAnother',
            'tooltip' => 'attachAnother',
        ],
        'submit' => [
            'label' => 'submit',
            'icon' => 'ui-submit',
            'tooltip' => 'submit',
        ],
        'handleEmployees' => [
            'label' => 'handleEmployees',
        ],
        'newConsulenteEsterno' => [
            'tooltip' => 'newConsulenteEsterno',
            'icon' => 'newConsulenteEsterno',
            'label' => 'newConsulenteEsterno',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
            'label' => 'createAnother',
            'icon' => 'createAnother',
        ],
        'AttachActivityEmployeeAction' => [
            'tooltip' => 'AttachActivityEmployeeAction',
            'icon' => 'AttachActivityEmployeeAction',
            'label' => 'AttachActivityEmployeeAction',
        ],
        'Collega Dipendente' => [
            'tooltip' => 'Collega Dipendente',
            'icon' => 'Collega Dipendente',
            'label' => 'Collega Dipendente',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'validation' => [
            'anagrafica' => [
                'required' => 'I dati anagrafici sono obbligatori',
                'unique' => 'Codice fiscale già presente',
                'regex' => 'Formato codice fiscale non valido',
            ],
            'matricola' => [
                'required' => 'La matricola è obbligatoria',
                'unique' => 'Matricola già assegnata',
                'regex' => 'Formato matricola non valido',
            ],
            'contratto' => [
                'required' => 'I dati contrattuali sono obbligatori',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di cessazione deve essere successiva all\'assunzione',
            ],
        ],
        'errors' => [
            'active_projects' => 'Dipendente assegnato a progetti attivi',
            'invalid_status' => 'Stato non valido per l\'operazione',
            'missing_documents' => 'Documenti obbligatori mancanti',
            'invalid_contract' => 'Dati contrattuali non validi',
        ],
        'warnings' => [
            'contract_expiring' => 'Contratto in scadenza',
            'missing_skills' => 'Competenze da aggiornare',
            'pending_reviews' => 'Valutazioni in sospeso',
        ],
        'info' => [
            'contract_updated' => 'Contratto aggiornato correttamente',
            'documents_complete' => 'Documentazione completa',
            'skills_verified' => 'Competenze verificate',
        ],
    ],
    'label' => 'Dipendente',
    'plural_label' => 'Dipendenti',
];
