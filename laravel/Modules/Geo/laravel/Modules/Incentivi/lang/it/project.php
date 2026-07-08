<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Progetto',
        'plural' => 'Progetti',
        'group' => [
            'name' => 'Incentivi',
            'description' => 'Gestione dei progetti e incentivi',
        ],
        'label' => 'Progetti',
        'sort' => 1,
        'icon' => 'incentivi-project',
    ],
    'fields' => [
        'base' => [
            'nome' => [
                'label' => 'Nome Progetto',
                'placeholder' => 'Inserisci il nome',
                'help' => 'Nome identificativo del progetto',
            ],
            'codice' => [
                'label' => 'Codice',
                'placeholder' => 'Inserisci il codice',
                'help' => 'Codice univoco del progetto',
            ],
            'descrizione' => [
                'label' => 'Descrizione',
                'placeholder' => 'Inserisci la descrizione',
                'help' => 'Descrizione dettagliata del progetto',
            ],
        ],
        'periodo' => [
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
            'durata' => [
                'label' => 'Durata',
                'help' => 'Durata prevista in mesi',
            ],
        ],
        'budget' => [
            'importo' => [
                'label' => 'Importo Budget',
                'placeholder' => 'Inserisci l\'importo',
                'help' => 'Budget totale del progetto',
            ],
            'speso' => [
                'label' => 'Importo Speso',
                'help' => 'Budget già utilizzato',
            ],
            'residuo' => [
                'label' => 'Importo Residuo',
                'help' => 'Budget ancora disponibile',
            ],
        ],
        'team' => [
            'responsabile' => [
                'label' => 'Responsabile',
                'placeholder' => 'Seleziona il responsabile',
                'help' => 'Responsabile del progetto',
            ],
            'membri' => [
                'label' => 'Membri Team',
                'placeholder' => 'Seleziona i membri',
                'help' => 'Team di progetto',
            ],
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del progetto',
            'options' => [
                'pianificazione' => 'In Pianificazione',
                'avviato' => 'Avviato',
                'in_corso' => 'In Corso',
                'sospeso' => 'Sospeso',
                'completato' => 'Completato',
                'chiuso' => 'Chiuso',
                'annullato' => 'Annullato',
            ],
            'description' => 'stato',
            'helper_text' => 'stato',
        ],
        'documenti' => [
            'label' => 'Documenti',
            'placeholder' => 'Carica i documenti',
            'help' => 'Documentazione di progetto',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sul progetto',
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
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'updated_at' => [
            'label' => 'updated_at',
            'description' => 'updated_at',
            'helper_text' => 'updated_at',
            'placeholder' => 'updated_at',
        ],
        'created_at' => [
            'label' => 'created_at',
            'description' => 'created_at',
            'helper_text' => 'created_at',
            'placeholder' => 'created_at',
        ],
        'determina' => [
            'label' => 'Determina',
            'description' => 'determina',
            'helper_text' => 'determina',
            'placeholder' => 'determina',
        ],
        'data_fine_esecuzione' => [
            'label' => 'Data Fine Esecuzione',
            'description' => 'data_fine_esecuzione',
            'helper_text' => 'data_fine_esecuzione',
            'placeholder' => 'data_fine_esecuzione',
        ],
        'data_inizio_esecuzione' => [
            'label' => 'Data Inizio Esecuzione',
            'description' => 'data_inizio_esecuzione',
            'helper_text' => 'data_inizio_esecuzione',
            'placeholder' => 'data_inizio_esecuzione',
        ],
        'data_aggiudicazione' => [
            'label' => 'Data Aggiudicazione',
            'description' => 'data_aggiudicazione',
            'helper_text' => 'data_aggiudicazione',
            'placeholder' => 'data_aggiudicazione',
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
        'componente_innovazione' => [
            'label' => 'Componente Innovazione',
            'description' => 'componente_innovazione',
            'helper_text' => 'componente_innovazione',
            'placeholder' => 'componente_innovazione',
        ],
        'componente_incentivante' => [
            'label' => 'Componente Incentivante',
            'description' => 'componente_incentivante',
            'helper_text' => 'componente_incentivante',
            'placeholder' => 'componente_incentivante',
        ],
        'importo_effettivo_fondo' => [
            'label' => 'Importo Effettivo Fondo',
            'description' => 'importo_effettivo_fondo',
            'helper_text' => 'importo_effettivo_fondo',
            'placeholder' => 'importo_effettivo_fondo',
        ],
        'importo_totale' => [
            'label' => 'Importo Totale',
            'description' => 'importo_totale',
            'helper_text' => 'importo_totale',
            'placeholder' => 'importo_totale',
        ],
        'percentuale_fondo' => [
            'label' => 'Percentuale Fondo',
            'description' => 'percentuale_fondo',
            'helper_text' => 'percentuale_fondo',
            'placeholder' => 'percentuale_fondo',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'description' => 'tipo',
            'helper_text' => 'tipo',
            'placeholder' => 'tipo',
        ],
        'nome' => [
            'label' => 'Nome',
            'description' => 'nome',
            'helper_text' => 'nome',
            'placeholder' => 'nome',
        ],
        'value' => [
            'label' => 'value',
        ],
        'is_active' => [
            'label' => 'is_active',
        ],
        'oggetto' => [
            'description' => 'oggetto',
            'helper_text' => 'oggetto',
            'placeholder' => 'oggetto',
            'label' => 'Oggetto',
        ],
        'ente_finanziatore' => [
            'description' => 'ente_finanziatore',
            'helper_text' => 'ente_finanziatore',
            'placeholder' => 'ente_finanziatore',
            'label' => 'Ente Finanziatore',
        ],
        'workgroup_id' => [
            'description' => 'workgroup_id',
            'helper_text' => 'workgroup_id',
            'placeholder' => 'workgroup_id',
            'label' => 'workgroup_id',
        ],
        'settore' => [
            'description' => 'settore',
            'helper_text' => 'settore',
            'placeholder' => 'settore',
            'label' => 'Settore',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'determina di aggiudicazione' => [
            'description' => 'determina di aggiudicazione',
            'helper_text' => 'determina di aggiudicazione',
            'placeholder' => 'determina di aggiudicazione',
            'label' => 'Determina di aggiudicazione',
        ],
        'ditta_trattativa' => [
            'description' => 'ditta_trattativa',
            'helper_text' => 'ditta_trattativa',
            'placeholder' => 'ditta_trattativa',
            'label' => 'Ditta Trattativa',
        ],
        'ditta_oneri_sicurezza' => [
            'description' => 'ditta_oneri_sicurezza',
            'helper_text' => 'ditta_oneri_sicurezza',
            'placeholder' => 'ditta_oneri_sicurezza',
            'label' => 'Ditta Oneri Sicurezza',
        ],
        'ditta_partitaiva' => [
            'description' => 'ditta_partitaiva',
            'helper_text' => 'ditta_partitaiva',
            'placeholder' => 'ditta_partitaiva',
            'label' => 'Ditta Partita iva',
        ],
        'ditta_sede' => [
            'description' => 'ditta_sede',
            'helper_text' => 'ditta_sede',
            'placeholder' => 'ditta_sede',
            'label' => 'Ditta Sede',
        ],
        'ditta_nome' => [
            'description' => 'ditta_nome',
            'helper_text' => 'ditta_nome',
            'placeholder' => 'ditta_nome',
            'label' => 'Ditta Nome',
        ],
        'dec' => [
            'description' => 'dec',
            'helper_text' => 'dec',
            'placeholder' => 'dec',
            'label' => 'DEC',
        ],
        'rup' => [
            'description' => 'rup',
            'helper_text' => 'rup',
            'placeholder' => 'rup',
            'label' => 'RUP',
        ],
        'area' => [
            'description' => 'area',
        ],
        'area_id' => [
            'description' => 'area_id',
        ],
        'departament_id' => [
            'description' => 'departament_id',
        ],
        'departament' => [
            'description' => 'Settore',
        ],
        'Settore' => [
            'description' => 'Settore',
            'helper_text' => 'Settore',
            'placeholder' => 'Settore',
            'label' => 'Settore',
        ],
        'department_id' => [
            'description' => 'department_id',
            'helper_text' => 'department_id',
            'placeholder' => 'department_id',
            'label' => 'Settore',
            'nome' => [
                'label' => 'Settore',
            ],
        ],
        'department' => [
            'nome' => [
                'label' => 'Settore',
            ],
            'description' => 'Settore',
            'helper_text' => 'Settore',
            'placeholder' => 'Settore',
        ],
        'stabiDirigente' => [
            'nome_stabi' => [
                'label' => 'Settore',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Progetto',
            'success' => 'Progetto creato con successo',
            'error' => 'Errore durante la creazione',
            'icon' => 'ui-create',
            'tooltip' => 'create',
        ],
        'update' => [
            'label' => 'Modifica',
            'success' => 'Progetto aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Progetto eliminato con successo',
            'error' => 'Errore durante l\'eliminazione',
            'confirm' => 'Sei sicuro di voler eliminare questo progetto?',
            'icon' => 'ui-delete',
            'tooltip' => 'delete',
        ],
        'start' => [
            'label' => 'Avvia',
            'success' => 'Progetto avviato con successo',
            'error' => 'Errore durante l\'avvio',
        ],
        'suspend' => [
            'label' => 'Sospendi',
            'success' => 'Progetto sospeso con successo',
            'error' => 'Errore durante la sospensione',
        ],
        'complete' => [
            'label' => 'Completa',
            'success' => 'Progetto completato con successo',
            'error' => 'Errore durante il completamento',
        ],
        'close' => [
            'label' => 'Chiudi',
            'success' => 'Progetto chiuso con successo',
            'error' => 'Errore durante la chiusura',
        ],
        'logout' => [
            'icon' => 'logout',
            'label' => 'logout',
            'tooltip' => 'logout',
        ],
        'profile' => [
            'icon' => 'profile',
            'label' => 'profile',
            'tooltip' => 'profile',
        ],
        'reorderRecords' => [
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'applyTableColumnManager' => [
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
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
        'edit' => [
            'label' => 'edit',
            'icon' => 'ui-edit',
            'tooltip' => 'edit',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'cancel' => [
            'icon' => 'ui-cancel',
            'label' => 'cancel',
            'tooltip' => 'cancel',
        ],
        'save' => [
            'icon' => 'ui-save',
            'label' => 'save',
            'tooltip' => 'save',
        ],
        'GeneratePDFWorkgroupCompositionAction' => [
            'icon' => 'GeneratePDFWorkgroupCompositionAction',
            'label' => 'Dispone Gruppo di Lavoro',
            'tooltip' => 'Scarica Dispone Gruppo di Lavoro',
        ],
        'list_log_activities' => [
            'tooltip' => 'Log Attività',
            'icon' => 'list_log_activities',
            'label' => 'Log Attività',
        ],
        'GeneratePDFProjectReportAction' => [
            'icon' => 'GeneratePDFProjectReportAction',
            'label' => 'Report Progetto',
            'tooltip' => 'Scarica Report Progetto',
        ],
        'submit' => [
            'tooltip' => 'submit',
            'icon' => 'submit',
            'label' => 'submit',
        ],
        'createAnother' => [
            'tooltip' => 'createAnother',
            'icon' => 'createAnother',
            'label' => 'createAnother',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'validation' => [
            'nome' => [
                'required' => 'Il nome è obbligatorio',
                'unique' => 'Questo nome è già in uso',
            ],
            'codice' => [
                'required' => 'Il codice è obbligatorio',
                'unique' => 'Questo codice è già in uso',
                'regex' => 'Il codice deve contenere solo lettere, numeri e trattini',
            ],
            'date' => [
                'required' => 'Le date sono obbligatorie',
                'date' => 'Le date devono essere valide',
                'after' => 'La data di fine deve essere successiva all\'inizio',
            ],
            'budget' => [
                'required' => 'Il budget è obbligatorio',
                'numeric' => 'Il budget deve essere numerico',
                'min' => 'Il budget deve essere maggiore di zero',
            ],
        ],
        'errors' => [
            'insufficient_budget' => 'Budget insufficiente',
            'invalid_status_transition' => 'Transizione di stato non valida',
            'team_incomplete' => 'Team incompleto',
            'dependencies_exist' => 'Esistono dipendenze attive',
        ],
        'warnings' => [
            'budget_low' => 'Budget quasi esaurito',
            'deadline_approaching' => 'Scadenza imminente',
            'overdue_activities' => 'Attività in ritardo',
            'missing_documentation' => 'Documentazione incompleta',
        ],
        'info' => [
            'milestones_updated' => 'Milestone aggiornate',
            'team_assigned' => 'Team assegnato correttamente',
            'budget_allocated' => 'Budget allocato correttamente',
            'documentation_complete' => 'Documentazione completa',
        ],
    ],
    'sections' => [
        'Importi e percentuali' => [
            'heading' => 'Importi e percentuali',
            'label' => 'Inserire l\'Importo Totale e attendere qualche secondo per il calcolo automatico degli altri campi.',
        ],
        'Informazioni' => [
            'heading' => 'Informazioni',
            'label' => 'Inserire le informazioni di base del progetto.',
        ],
        'Ditta' => [
            'heading' => 'Ditta',
            'label' => 'Inserire le informazioni relative alla ditta.',
        ],
        '' => [
            'heading' => '',
        ],
    ],
    'label' => 'Progetto',
    'plural_label' => 'Progetti',
];
