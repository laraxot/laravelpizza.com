<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Ambiente',
        'plural' => 'Ambiente',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione delle variabili d\'ambiente e configurazione del sistema',
        ],
        'label' => 'env',
        'sort' => '12',
        'icon' => 'xot-env',
    ],
    'fields' => [
        'key' => [
            'label' => 'Chiave',
            'placeholder' => 'Inserisci la chiave (es. APP_NAME)',
            'help' => 'Nome della variabile d\'ambiente in maiuscolo',
        ],
        'value' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore della variabile d\'ambiente',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di variabile',
            'help' => 'Tipo di dato della variabile',
            'options' => [
                'string' => 'Testo',
                'integer' => 'Numero intero',
                'float' => 'Numero decimale',
                'boolean' => 'Booleano',
                'array' => 'Array',
                'null' => 'Nullo',
            ],
        ],
        'environment' => [
            'label' => 'Ambiente',
            'placeholder' => 'Seleziona l\'ambiente di applicazione',
            'help' => 'Ambiente in cui la variabile è attiva',
            'options' => [
                'local' => 'Sviluppo locale',
                'testing' => 'Test',
                'staging' => 'Pre-produzione',
                'production' => 'Produzione',
                'all' => 'Tutti gli ambienti',
            ],
        ],
        'is_sensitive' => [
            'label' => 'Dato Sensibile',
            'help' => 'Indica se il valore contiene dati sensibili da mascherare',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Descrizione dettagliata dello scopo della variabile',
        ],
        'group' => [
            'label' => 'Gruppo',
            'placeholder' => 'Seleziona il gruppo',
            'help' => 'Gruppo funzionale della variabile',
            'options' => [
                'app' => 'Applicazione',
                'database' => 'Database',
                'mail' => 'Email',
                'queue' => 'Code',
                'cache' => 'Cache',
                'services' => 'Servizi',
                'other' => 'Altro',
            ],
        ],
        'telegram_bot_token' => [
            'description' => 'telegram_bot_token',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuova Variabile',
            'success' => 'Variabile d\'ambiente creata con successo',
            'error' => 'Errore durante la creazione della variabile',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Variabile d\'ambiente aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento della variabile',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Variabile d\'ambiente eliminata con successo',
            'error' => 'Errore durante l\'eliminazione della variabile',
        ],
        'backup' => [
            'label' => 'Backup',
            'success' => 'Backup del file .env creato con successo',
            'error' => 'Errore durante la creazione del backup',
        ],
        'restore' => [
            'label' => 'Ripristina',
            'success' => 'File .env ripristinato con successo',
            'error' => 'Errore durante il ripristino del file',
        ],
        'encrypt' => [
            'label' => 'Cripta',
            'success' => 'Valore criptato con successo',
            'error' => 'Errore durante la criptazione',
        ],
    ],
    'messages' => [
        'validation' => [
            'key' => [
                'required' => 'La chiave è obbligatoria',
                'unique' => 'Questa chiave è già in uso',
                'regex' => 'La chiave può contenere solo lettere maiuscole, numeri e underscore',
                'reserved' => 'Questa chiave è riservata dal sistema',
            ],
            'value' => [
                'required' => 'The value is required',
                'type' => 'Il valore deve essere del tipo :type',
            ],
            'environment' => [
                'required' => 'The environment is required',
                'exists' => 'L\'ambiente selezionato non è valido',
            ],
        ],
        'warnings' => [
            'production_edit' => 'Attenzione: stai modificando variabili d\'ambiente in produzione',
            'backup_recommended' => 'Si consiglia di effettuare un backup prima di procedere',
            'sensitive_data' => 'Attenzione: questo valore contiene dati sensibili',
            'restart_required' => 'Potrebbe essere necessario riavviare l\'applicazione',
        ],
        'info' => [
            'env_loaded' => 'File .env caricato correttamente',
            'backup_created' => 'Backup creato in :path',
            'changes_saved' => 'Modifiche salvate nel file .env',
        ],
    ],
    'title' => 'env',
];
