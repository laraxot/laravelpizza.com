<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Lock Cache',
        'plural' => 'Lock Cache',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione del sistema e delle sue risorse',
        ],
        'label' => 'locks',
        'sort' => 11,
        'icon' => 'xot-lock',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci la chiave del lock',
            'help' => 'Chiave univoca identificativa del lock',
        ],
        'owner' => [
            'label' => 'Proprietario',
            'placeholder' => 'Inserisci il proprietario del lock',
            'help' => 'Processo o utente proprietario del lock',
        ],
        'expiration' => [
            'label' => 'Scadenza',
            'placeholder' => 'Seleziona la data e ora di scadenza',
            'help' => 'Momento in cui il lock scadrà automaticamente',
        ],
        'status' => [
            'label' => 'Stato',
            'help' => 'Stato attuale del lock nel sistema',
            'options' => [
                'locked' => 'Bloccato',
                'unlocked' => 'Sbloccato',
                'expired' => 'Scaduto',
                'pending' => 'In Attesa',
                'error' => 'Errore',
            ],
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data e ora di creazione del lock',
        ],
        'updated_at' => [
            'label' => 'Ultimo Aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica del lock',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione opzionale del lock',
        ],
        'type' => [
            'label' => 'Tipo Lock',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia del lock',
            'options' => [
                'file' => 'File',
                'process' => 'Processo',
                'resource' => 'Risorsa',
                'custom' => 'Personalizzato',
            ],
        ],
        'create' => [
            'label' => 'create',
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
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'actions' => [
        'lock' => [
            'label' => 'Blocca',
            'success' => 'Lock creato con successo',
            'error' => 'Errore durante la creazione del lock',
        ],
        'unlock' => [
            'label' => 'Sblocca',
            'success' => 'Lock rimosso con successo',
            'error' => 'Errore durante la rimozione del lock',
        ],
        'refresh' => [
            'label' => 'Aggiorna',
            'success' => 'Lock aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del lock',
        ],
        'force_unlock' => [
            'label' => 'Forza Sblocco',
            'success' => 'Lock forzatamente rimosso',
            'error' => 'Impossibile forzare la rimozione del lock',
        ],
        'extend' => [
            'label' => 'Estendi',
            'success' => 'Scadenza del lock estesa con successo',
            'error' => 'Impossibile estendere la scadenza del lock',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'La chiave è obbligatoria',
                'unique' => 'Questa chiave è già in uso',
                'regex' => 'La chiave può contenere solo lettere, numeri e trattini',
            ],
            'owner' => [
                'required' => 'Il proprietario è obbligatorio',
                'exists' => 'Il proprietario specificato non esiste',
            ],
            'expiration' => [
                'required' => 'La scadenza è obbligatoria',
                'date' => 'La data di scadenza non è valida',
                'after' => 'La data di scadenza deve essere successiva a ora',
                'before' => 'La data di scadenza non può superare 24 ore',
            ],
            'type' => [
                'required' => 'Il tipo di lock è obbligatorio',
                'in' => 'Il tipo selezionato non è valido',
            ],
        ],
        'errors' => [
            'already_locked' => 'Questa risorsa è già bloccata',
            'not_locked' => 'Questa risorsa non è bloccata',
            'not_owner' => 'Non sei il proprietario di questo lock',
            'expired' => 'Il lock è scaduto',
            'system_error' => 'Errore di sistema durante l\'operazione',
        ],
        'info' => [
            'auto_unlock' => 'Il lock verrà automaticamente rimosso alla scadenza',
            'force_required' => 'Potrebbe essere necessario forzare lo sblocco',
            'extend_available' => 'È possibile estendere la durata del lock',
        ],
    ],
    'model' => [
        'label' => 'cache lock.model',
    ],
];
