<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Attività Progetto',
        'plural' => 'Attività Progetti',
        'group' => [
            'name' => 'Incentivi',
            'description' => 'Gestione delle attività dei progetti',
        ],
        'label' => 'Attività del Progetto',
        'sort' => 71,
        'icon' => 'incentivi-project-activities',
    ],
    'fields' => [
        'nome' => [
            'label' => 'Nome Attività',
            'placeholder' => 'Inserisci il nome dell\'attività',
            'help' => 'Nome identificativo dell\'attività',
            'description' => 'nome',
            'helper_text' => 'nome',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione dell\'attività',
            'help' => 'Descrizione dettagliata dell\'attività',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di attività',
            'help' => 'Tipologia di attività',
            'options' => [
                'analisi' => 'Analisi',
                'sviluppo' => 'Sviluppo',
                'test' => 'Testing',
                'documentazione' => 'Documentazione',
                'coordinamento' => 'Coordinamento',
            ],
            'description' => 'tipo',
            'helper_text' => 'tipo',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'Data di inizio dell\'attività',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'Data di fine dell\'attività',
        ],
        'durata' => [
            'label' => 'Durata',
            'placeholder' => 'Inserisci la durata in ore',
            'help' => 'Durata stimata in ore',
        ],
        'priorita' => [
            'label' => 'Priorità',
            'placeholder' => 'Seleziona la priorità',
            'help' => 'Livello di priorità dell\'attività',
            'options' => [
                'bassa' => 'Bassa',
                'media' => 'Media',
                'alta' => 'Alta',
                'critica' => 'Critica',
            ],
        ],
        'responsabile' => [
            'label' => 'Responsabile',
            'placeholder' => 'Seleziona il responsabile',
            'help' => 'Responsabile dell\'attività',
        ],
        'partecipanti' => [
            'label' => 'Partecipanti',
            'placeholder' => 'Seleziona i partecipanti',
            'help' => 'Team assegnato all\'attività',
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale dell\'attività',
            'options' => [
                'da_iniziare' => 'Da Iniziare',
                'in_corso' => 'In Corso',
                'in_revisione' => 'In Revisione',
                'completata' => 'Completata',
                'sospesa' => 'Sospesa',
            ],
        ],
        'percentuale' => [
            'label' => 'Percentuale Completamento',
            'placeholder' => 'Inserisci la percentuale (0-100)',
            'help' => 'Percentuale di completamento dell\'attività',
        ],
        'ore_lavorate' => [
            'label' => 'Ore Lavorate',
            'placeholder' => 'Inserisci le ore lavorate',
            'help' => 'Ore effettivamente lavorate sull\'attività',
        ],
        'project_id' => [
            'label' => 'Progetto',
            'placeholder' => 'Seleziona il progetto',
            'help' => 'Progetto di appartenenza dell\'attività',
        ],
        'anno_competenza' => [
            'label' => 'Anno Competenza',
            'placeholder' => 'Seleziona l\'anno di competenza',
            'help' => 'Anno di competenza per l\'attività',
            'description' => 'anno_competenza',
            'helper_text' => 'anno_competenza',
        ],
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo',
            'help' => 'Importo associato all\'attività',
            'description' => 'importo',
            'helper_text' => 'importo',
        ],
        'quota_percentuale' => [
            'label' => 'Quota Percentuale',
            'placeholder' => 'Inserisci la quota percentuale',
            'help' => 'Quota percentuale dell\'attività',
            'description' => 'quota_percentuale',
            'helper_text' => 'quota_percentuale',
        ],
        'employees' => [
            'full_name' => [
                'label' => 'Nome Completo',
                'placeholder' => 'Nome completo del dipendente',
                'help' => 'Nome completo del dipendente assegnato',
            ],
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'placeholder' => 'Seleziona le colonne da visualizzare',
            'help' => 'Gestisci la visibilità delle colonne nella tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina Record',
            'placeholder' => 'Trascina per riordinare',
            'help' => 'Riordina i record trascinandoli',
        ],
        'resetFilters' => [
            'label' => 'Reset Filtri',
            'placeholder' => 'Rimuovi tutti i filtri',
            'help' => 'Rimuovi tutti i filtri applicati',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'placeholder' => 'Applica i filtri selezionati',
            'help' => 'Applica i filtri alla tabella',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'placeholder' => 'Apri pannello filtri',
            'help' => 'Apri il pannello dei filtri',
        ],
        'create' => [
            'label' => 'Crea',
            'placeholder' => 'Crea nuovo elemento',
            'help' => 'Crea un nuovo elemento',
        ],
        'attach' => [
            'label' => 'Allega',
            'placeholder' => 'Allega elemento',
            'help' => 'Allega un elemento esistente',
        ],
        'recordId' => [
            'label' => 'ID Record',
            'placeholder' => 'Identificativo del record',
            'help' => 'Identificativo univoco del record',
        ],
        'handleEmployees' => [
            'label' => 'Gestisci Dipendenti',
            'placeholder' => 'Gestisci i dipendenti assegnati',
            'help' => 'Gestisci i dipendenti assegnati all\'attività',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Attività',
            'success' => 'Attività creata con successo',
            'error' => 'Errore durante la creazione dell\'attività',
            'confirmation' => 'Sei sicuro di voler creare questa attività?',
            'icon' => 'ui-create',
            'tooltip' => 'create',
        ],
        'update' => [
            'label' => 'Modifica Attività',
            'success' => 'Attività aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'attività',
        ],
        'delete' => [
            'label' => 'Elimina Attività',
            'success' => 'Attività eliminata con successo',
            'error' => 'Errore durante l\'eliminazione dell\'attività',
            'confirmation' => 'Sei sicuro di voler eliminare questa attività? Questa azione è irreversibile.',
            'icon' => 'ui-delete',
            'tooltip' => 'delete',
        ],
        'start' => [
            'label' => 'Avvia Attività',
            'success' => 'Attività avviata con successo',
            'error' => 'Errore durante l\'avvio dell\'attività',
            'confirmation' => 'Sei sicuro di voler avviare questa attività?',
        ],
        'complete' => [
            'label' => 'Completa Attività',
            'success' => 'Attività completata con successo',
            'error' => 'Errore durante il completamento dell\'attività',
            'confirmation' => 'Sei sicuro di voler completare questa attività?',
        ],
        'view' => [
            'label' => 'Visualizza Attività',
            'success' => 'Attività visualizzata',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Modifiche salvate con successo',
            'error' => 'Errore durante il salvataggio delle modifiche',
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
        'handleEmployees' => [
            'label' => 'handleEmployees',
            'icon' => 'handleEmployees',
            'tooltip' => 'handleEmployees',
        ],
        'test' => [
            'label' => 'test',
        ],
        'cancel' => [
            'icon' => 'cancel',
            'tooltip' => 'cancel',
            'label' => 'cancel',
        ],
        'submit' => [
            'tooltip' => 'submit',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'attach' => [
            'tooltip' => 'attach',
            'icon' => 'attach',
            'label' => 'attach',
        ],
        'attachAnother' => [
            'tooltip' => 'attachAnother',
            'icon' => 'attachAnother',
            'label' => 'attachAnother',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'validation' => [
            'nome' => [
                'required' => 'Il nome dell\'attività è obbligatorio',
                'unique' => 'Questo nome è già in uso per un\'altra attività',
                'max' => 'Il nome non può superare i 255 caratteri',
            ],
            'tipo' => [
                'required' => 'Il tipo di attività è obbligatorio',
                'in' => 'Il tipo selezionato non è valido',
            ],
            'data_inizio' => [
                'required' => 'La data di inizio è obbligatoria',
                'date' => 'La data di inizio deve essere valida',
                'before' => 'La data di inizio deve essere precedente alla data di fine',
            ],
            'data_fine' => [
                'required' => 'La data di fine è obbligatoria',
                'date' => 'La data di fine deve essere valida',
                'after' => 'La data di fine deve essere successiva alla data di inizio',
            ],
            'durata' => [
                'required' => 'La durata è obbligatoria',
                'numeric' => 'La durata deve essere un numero',
                'min' => 'La durata deve essere maggiore di zero',
            ],
            'priorita' => [
                'required' => 'La priorità è obbligatoria',
                'in' => 'La priorità selezionata non è valida',
            ],
            'stato' => [
                'required' => 'Lo stato è obbligatorio',
                'in' => 'Lo stato selezionato non è valido',
            ],
            'percentuale' => [
                'numeric' => 'La percentuale deve essere un numero',
                'min' => 'La percentuale deve essere almeno 0',
                'max' => 'La percentuale non può superare 100',
            ],
            'ore_lavorate' => [
                'numeric' => 'Le ore lavorate devono essere un numero',
                'min' => 'Le ore lavorate devono essere almeno 0',
            ],
        ],
        'errors' => [
            'dependencies_incomplete' => 'Non è possibile procedere: attività dipendenti non completate',
            'resources_unavailable' => 'Risorse non disponibili per questa attività',
            'invalid_status_transition' => 'Transizione di stato non valida per questa attività',
            'schedule_conflict' => 'Conflitto di schedulazione con altre attività',
            'not_found' => 'Attività non trovata',
            'unauthorized' => 'Non sei autorizzato a eseguire questa azione',
        ],
        'warnings' => [
            'overdue' => 'Questa attività è in ritardo rispetto alla scadenza prevista',
            'approaching_deadline' => 'La scadenza di questa attività si avvicina',
            'resource_overallocation' => 'Attenzione: risorse sovrallocate per questo periodo',
            'dependencies_pending' => 'Alcune attività dipendenti sono ancora in corso',
        ],
        'info' => [
            'dependencies_ok' => 'Tutte le dipendenze sono state verificate',
            'resources_assigned' => 'Risorse assegnate correttamente all\'attività',
            'milestone_reached' => 'Milestone raggiunta con successo',
            'on_track' => 'L\'attività procede secondo i tempi previsti',
        ],
        'empty_states' => [
            'default' => 'Nessuna attività trovata',
            'search' => 'Nessuna attività corrisponde ai criteri di ricerca',
            'filtered' => 'Nessuna attività corrisponde ai filtri applicati',
        ],
    ],
    'title' => 'Attività Progetto',
    'description' => 'Gestione completa delle attività dei progetti incentivi',
];
