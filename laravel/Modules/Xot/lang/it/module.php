<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Moduli',
        'plural' => 'Moduli',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione dei moduli e delle estensioni',
        ],
        'label' => 'module',
        'sort' => 17,
        'icon' => 'xot-module',
    ],
    'fields' => [
        'basic' => [
            'name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome del modulo',
                'help' => 'Nome identificativo del modulo',
            ],
            'description' => [
                'label' => 'Descrizione',
                'placeholder' => 'Inserisci la descrizione del modulo',
                'help' => 'Descrizione dettagliata delle funzionalità',
            ],
            'version' => [
                'label' => 'Versione',
                'placeholder' => 'Inserisci la versione (es. 1.0.0)',
                'help' => 'Versione semantica del modulo',
            ],
            'status' => [
                'label' => 'Stato',
                'help' => 'Stato attuale del modulo',
                'options' => [
                    'enabled' => 'Abilitato',
                    'disabled' => 'Disabilitato',
                    'pending' => 'In attesa',
                    'error' => 'Errore',
                ],
            ],
        ],
        'details' => [
            'dependencies' => [
                'label' => 'Dipendenze',
                'placeholder' => 'Seleziona le dipendenze richieste',
                'help' => 'Altri moduli necessari per il funzionamento',
            ],
            'author' => [
                'label' => 'Autore',
                'placeholder' => 'Inserisci l\'autore del modulo',
                'help' => 'Sviluppatore o organizzazione',
            ],
            'license' => [
                'label' => 'Licenza',
                'placeholder' => 'Inserisci la licenza',
                'help' => 'Tipo di licenza del modulo',
                'options' => [
                    'mit' => 'MIT',
                    'apache' => 'Apache 2.0',
                    'gpl' => 'GPL v3',
                    'proprietary' => 'Proprietaria',
                ],
            ],
            'homepage' => [
                'label' => 'Homepage',
                'placeholder' => 'URL della documentazione',
                'help' => 'Pagina web del modulo',
            ],
        ],
        'system' => [
            'order' => [
                'label' => 'Ordine',
                'placeholder' => 'Inserisci l\'ordine di caricamento',
                'help' => 'Priorità di caricamento del modulo',
            ],
            'path' => [
                'label' => 'Percorso',
                'help' => 'Percorso di installazione del modulo',
            ],
            'namespace' => [
                'label' => 'Namespace',
                'help' => 'Namespace PHP del modulo',
            ],
        ],
        'timestamps' => [
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di installazione del modulo',
            ],
            'updated_at' => [
                'label' => 'Ultimo Aggiornamento',
                'help' => 'Data dell\'ultimo aggiornamento',
            ],
        ],
    ],
    'actions' => [
        'install' => [
            'label' => 'Installa',
            'success' => 'Modulo installato con successo',
            'error' => 'Errore durante l\'installazione',
        ],
        'uninstall' => [
            'label' => 'Disinstalla',
            'success' => 'Modulo disinstallato con successo',
            'error' => 'Errore durante la disinstallazione',
            'confirm' => 'Sei sicuro di voler disinstallare questo modulo?',
        ],
        'enable' => [
            'label' => 'Abilita',
            'success' => 'Modulo abilitato con successo',
            'error' => 'Errore durante l\'abilitazione',
        ],
        'disable' => [
            'label' => 'Disabilita',
            'success' => 'Modulo disabilitato con successo',
            'error' => 'Errore durante la disabilitazione',
        ],
        'update' => [
            'label' => 'Aggiorna',
            'success' => 'Modulo aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'migrate' => [
            'label' => 'Migra Database',
            'success' => 'Migrazione completata con successo',
            'error' => 'Errore durante la migrazione',
        ],
        'rollback' => [
            'label' => 'Ripristina Database',
            'success' => 'Ripristino completato con successo',
            'error' => 'Errore durante il ripristino',
        ],
        'publish' => [
            'label' => 'Pubblica Risorse',
            'success' => 'Risorse pubblicate con successo',
            'error' => 'Errore durante la pubblicazione',
        ],
    ],
    'messages' => [
        'validation' => [
            'name' => [
                'required' => 'Il nome è obbligatorio',
                'unique' => 'Questo nome è già in uso',
                'regex' => 'Il nome può contenere solo lettere, numeri e trattini',
            ],
            'version' => [
                'required' => 'La versione è obbligatoria',
                'regex' => 'Il formato deve essere X.Y.Z',
            ],
            'dependencies' => [
                'exists' => 'Uno o più moduli dipendenti non esistono',
                'enabled' => 'Uno o più moduli dipendenti non sono abilitati',
            ],
        ],
        'errors' => [
            'dependency_missing' => 'Dipendenza mancante: :name',
            'incompatible_version' => 'Versione incompatibile: :name richiede :version',
            'installation_failed' => 'Installazione fallita: :reason',
            'migration_failed' => 'Migrazione fallita: :reason',
            'system_incompatible' => 'Sistema incompatibile: richiede :requirement',
        ],
        'warnings' => [
            'disable_core' => 'Attenzione: stai per disabilitare un modulo core',
            'uninstall_dependencies' => 'Attenzione: questo modulo ha delle dipendenze',
            'update_available' => 'È disponibile la versione :version',
            'backup_recommended' => 'Si consiglia di effettuare un backup prima di procedere',
        ],
        'info' => [
            'dependencies_ok' => 'Tutte le dipendenze sono soddisfatte',
            'system_compatible' => 'Il sistema è compatibile',
            'migrations_pending' => 'Ci sono migrazioni in sospeso',
        ],
    ],
];
