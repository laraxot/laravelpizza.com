<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Extra',
        'plural' => 'Extra',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione delle funzionalità aggiuntive del sistema',
        ],
        'label' => 'extra',
        'sort' => 13,
        'icon' => 'xot-extra',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dell\'extra',
            'help' => 'Nome identificativo dell\'extra',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione dettagliata',
            'help' => 'Descrizione completa delle funzionalità dell\'extra',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di extra',
            'help' => 'Categoria funzionale dell\'extra',
            'options' => [
                'config' => 'Configurazione',
                'asset' => 'Risorsa',
                'plugin' => 'Plugin',
                'theme' => 'Tema',
                'widget' => 'Widget',
                'service' => 'Servizio',
                'integration' => 'Integrazione',
                'utility' => 'Utilità',
            ],
        ],
        'status' => [
            'label' => 'Stato',
            'help' => 'Stato attuale dell\'extra',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
                'pending' => 'In attesa',
                'error' => 'Errore',
                'updating' => 'In aggiornamento',
            ],
        ],
        'version' => [
            'label' => 'Versione',
            'placeholder' => 'Inserisci la versione (es. 1.0.0)',
            'help' => 'Versione semantica dell\'extra',
        ],
        'dependencies' => [
            'label' => 'Dipendenze',
            'placeholder' => 'Seleziona le dipendenze richieste',
            'help' => 'Altri extra o componenti necessari',
        ],
        'priority' => [
            'label' => 'Priorità',
            'placeholder' => 'Seleziona la priorità',
            'help' => 'Priorità di caricamento dell\'extra',
            'options' => [
                'high' => 'Alta',
                'medium' => 'Media',
                'low' => 'Bassa',
            ],
        ],
        'settings' => [
            'label' => 'Impostazioni',
            'placeholder' => 'Configura le impostazioni',
            'help' => 'Configurazioni specifiche dell\'extra',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data e ora di creazione dell\'extra',
        ],
        'updated_at' => [
            'label' => 'Ultimo Aggiornamento',
            'help' => 'Data e ora dell\'ultima modifica',
        ],
        'id' => [
            'label' => 'id',
        ],
        'model_type' => [
            'label' => 'model_type',
        ],
        'model_id' => [
            'label' => 'model_id',
        ],
        'extra_attributes' => [
            'label' => 'extra_attributes',
        ],
        'create' => [
            'label' => 'create',
        ],
        'edit' => [
            'label' => 'edit',
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
        'install' => [
            'label' => 'Installa',
            'success' => 'Extra installato con successo',
            'error' => 'Errore durante l\'installazione',
        ],
        'uninstall' => [
            'label' => 'Disinstalla',
            'success' => 'Extra disinstallato con successo',
            'error' => 'Errore durante la disinstallazione',
        ],
        'activate' => [
            'label' => 'Attiva',
            'success' => 'Extra attivato con successo',
            'error' => 'Errore durante l\'attivazione',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'success' => 'Extra disattivato con successo',
            'error' => 'Errore durante la disattivazione',
        ],
        'update' => [
            'label' => 'Aggiorna',
            'success' => 'Extra aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'configure' => [
            'label' => 'Configura',
            'success' => 'Configurazione salvata con successo',
            'error' => 'Errore durante il salvataggio della configurazione',
        ],
    ],
    'messages' => [
        'validation' => [
            'name' => [
                'required' => 'Il nome è obbligatorio',
                'unique' => 'Questo nome è già in uso',
                'regex' => 'Il nome può contenere solo lettere, numeri e trattini',
            ],
            'type' => [
                'required' => 'Il tipo è obbligatorio',
                'in' => 'Il tipo selezionato non è valido',
            ],
            'version' => [
                'required' => 'La versione è obbligatoria',
                'regex' => 'Il formato della versione deve essere X.Y.Z',
            ],
            'priority' => [
                'required' => 'La priorità è obbligatoria',
                'in' => 'La priorità selezionata non è valida',
            ],
        ],
        'errors' => [
            'dependency_missing' => 'Dipendenza mancante: :name',
            'incompatible_version' => 'Versione incompatibile: :name richiede :version',
            'installation_failed' => 'Installazione fallita: :reason',
            'configuration_invalid' => 'Configurazione non valida: :reason',
            'system_incompatible' => 'Sistema incompatibile: richiede :requirement',
        ],
        'warnings' => [
            'update_available' => 'È disponibile un aggiornamento alla versione :version',
            'dependency_update' => 'La dipendenza :name richiede un aggiornamento',
            'backup_recommended' => 'Si consiglia di effettuare un backup prima di procedere',
        ],
        'info' => [
            'dependencies_ok' => 'Tutte le dipendenze sono soddisfatte',
            'configuration_valid' => 'La configurazione è valida',
            'system_compatible' => 'Il sistema è compatibile',
        ],
    ],
    'model' => [
        'label' => 'extra.model',
    ],
];
