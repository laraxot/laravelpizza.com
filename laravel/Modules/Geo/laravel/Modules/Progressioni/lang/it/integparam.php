<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Parametri Integrazione',
        'group' => 'Gestione Progressioni',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 50,
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco del parametro',
        ],
        'ente' => [
            'label' => 'Ente',
            'placeholder' => 'Inserisci codice ente',
            'help' => 'Codice identificativo dell\'ente (max 10 caratteri)',
        ],
        'matr' => [
            'label' => 'Matricola',
            'placeholder' => 'Inserisci matricola',
            'help' => 'Matricola del dipendente (max 10 caratteri)',
        ],
        'conome' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci cognome',
            'help' => 'Cognome del dipendente (max 50 caratteri)',
        ],
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'help' => 'Nome del dipendente (max 50 caratteri)',
        ],
        'anv2kd' => [
            'label' => 'Data Inizio Validità',
            'placeholder' => 'Seleziona data inizio',
            'help' => 'Data di inizio validità del parametro',
        ],
        'anv2ka' => [
            'label' => 'Data Fine Validità',
            'placeholder' => 'Seleziona data fine',
            'help' => 'Data di fine validità del parametro',
        ],
        'anvist' => [
            'label' => 'Stato',
            'placeholder' => 'Inserisci stato',
            'help' => 'Stato del parametro (0 = inattivo, 1 = attivo)',
        ],
        'anvpar' => [
            'label' => 'Parametro',
            'placeholder' => 'Inserisci parametro',
            'help' => 'Codice del parametro (max 20 caratteri)',
        ],
        'anvimp' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci importo',
            'help' => 'Importo associato al parametro (5 decimali)',
        ],
        'anvqta' => [
            'label' => 'Quantità',
            'placeholder' => 'Inserisci quantità',
            'help' => 'Quantità associata al parametro (2 decimali)',
        ],
        'anvvoc' => [
            'label' => 'Vocabolario',
            'placeholder' => 'Inserisci vocabolario',
            'help' => 'Codice vocabolario (max 10 caratteri)',
        ],
        'anvdes' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci descrizione',
            'help' => 'Descrizione dettagliata del parametro (max 100 caratteri)',
            'description' => 'anvdes',
            'helper_text' => 'anvdes',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'create' => [
            'label' => 'create',
        ],
        'layout' => [
            'label' => 'layout',
        ],
        'view' => [
            'label' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'message' => [
            'label' => 'message',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Parametro',
            'success' => 'Parametro di integrazione creato con successo',
            'error' => 'Errore durante la creazione del parametro',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'edit' => [
            'label' => 'Modifica Parametro',
            'success' => 'Parametro di integrazione modificato con successo',
            'error' => 'Errore durante la modifica del parametro',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Parametro',
            'success' => 'Parametro di integrazione eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del parametro',
            'confirmation' => 'Sei sicuro di voler eliminare questo parametro? Questa azione è irreversibile.',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'Visualizza Parametro',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'resetColumnManager' => [
            'tooltip' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'label' => 'resetColumnManager',
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
        'removeAllFilters' => [
            'label' => 'removeAllFilters',
            'icon' => 'removeAllFilters',
            'tooltip' => 'removeAllFilters',
        ],
    ],
    'filters' => [
        'ente' => [
            'label' => 'Filtra per Ente',
        ],
        'anvist' => [
            'label' => 'Filtra per Stato',
        ],
        'currently_valid' => [
            'label' => 'Solo Parametri Validi',
        ],
    ],
    'sections' => [
        'anagrafica' => [
            'label' => 'Dati Anagrafici',
            'description' => 'Informazioni identificative del dipendente',
        ],
        'validita' => [
            'label' => 'Periodo di Validità',
            'description' => 'Date di inizio e fine validità del parametro',
        ],
        'parametri' => [
            'label' => 'Parametri di Configurazione',
            'description' => 'Valori e configurazioni specifiche del parametro',
        ],
        'Dati Anagrafici' => [
            'label' => 'Dati Anagrafici',
            'heading' => 'Dati Anagrafici',
        ],
        'Validità Temporale' => [
            'label' => 'Validità Temporale',
            'heading' => 'Validità Temporale',
        ],
        'Parametri' => [
            'label' => 'Parametri',
            'heading' => 'Parametri',
        ],
    ],
    'messages' => [
        'empty_state' => 'Nessun parametro di integrazione trovato',
        'search_placeholder' => 'Cerca parametri...',
        'validation' => [
            'date_range' => 'La data di fine validità deve essere successiva alla data di inizio',
            'required_field' => 'Questo campo è obbligatorio',
            'max_length' => 'Il campo non può superare i :max caratteri',
            'numeric' => 'Il campo deve essere un numero valido',
        ],
    ],
    'model' => [
        'label' => 'Modello Parametri Integrazione',
        'placeholder' => 'Seleziona modello parametri',
        'tooltip' => 'Modello dati per i parametri di integrazione',
        'helper_text' => 'Rappresentazione del modello dati utilizzato per gestire i parametri di integrazione del sistema',
        'help' => 'Modello che definisce la struttura dati per i parametri di integrazione',
    ],
    'label' => 'integparam',
];
