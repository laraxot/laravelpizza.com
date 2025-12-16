<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Dispositivi',
        'plural_label' => 'Dispositivi',
        'group' => [
            'name' => 'Sicurezza',
            'description' => 'Gestione dispositivi e sicurezza',
        ],
        'sort' => 50,
        'icon' => 'heroicon-o-device-phone-mobile',
        'badge' => 'Gestione dispositivi utente',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Dispositivo',
        'plural' => 'Dispositivi',
        'description' => 'Gestione e monitoraggio dei dispositivi degli utenti',
    ],
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    'fields' => [
        'uuid' => [
            'label' => 'UUID',
            'placeholder' => 'Inserisci l\'UUID del dispositivo',
            'tooltip' => 'Identificativo univoco universale',
            'helper_text' => 'Codice alfanumerico che identifica in modo univoco il dispositivo nel sistema',
            'help' => 'Identificativo univoco del dispositivo',
        ],
        'mobile_id' => [
            'label' => 'Mobile ID',
            'placeholder' => 'Inserisci l\'ID mobile',
            'tooltip' => 'Identificativo specifico per dispositivi mobili',
            'helper_text' => 'Codice utilizzato per identificare il dispositivo nelle applicazioni mobile',
            'help' => 'Identificativo mobile del dispositivo',
        ],
        'languages' => [
            'label' => 'Lingue',
            'placeholder' => 'Aggiungi una lingua',
            'tooltip' => 'Lingue supportate dal dispositivo',
            'helper_text' => 'Elenco delle lingue configurate o supportate dal dispositivo (formato: it, en, es)',
            'help' => 'Seleziona o digita i codici delle lingue (es. it, en, es)',
        ],
        'device' => [
            'label' => 'Nome Dispositivo',
            'placeholder' => 'Inserisci il nome del dispositivo',
            'tooltip' => 'Nome identificativo del dispositivo',
            'helper_text' => 'Nome descrittivo o modello del dispositivo utilizzato dall\'utente',
            'help' => 'Nome del dispositivo',
        ],
        'platform' => [
            'label' => 'Piattaforma',
            'placeholder' => 'Inserisci la piattaforma',
            'tooltip' => 'Sistema operativo del dispositivo',
            'helper_text' => 'Sistema operativo o piattaforma su cui funziona il dispositivo',
            'help' => 'Piattaforma del dispositivo (iOS, Android, Windows, Linux, macOS)',
        ],
        'browser' => [
            'label' => 'Browser',
            'placeholder' => 'Inserisci il browser',
            'tooltip' => 'Browser web utilizzato',
            'helper_text' => 'Applicazione browser utilizzata per navigare su internet',
            'help' => 'Browser utilizzato (Chrome, Firefox, Safari, Edge)',
        ],
        'version' => [
            'label' => 'Versione',
            'placeholder' => 'Inserisci la versione',
            'tooltip' => 'Versione del software',
            'helper_text' => 'Numero di versione del browser o del sistema operativo',
            'help' => 'Versione del browser o sistema operativo',
        ],
        'is_robot' => [
            'label' => 'È Robot',
            'placeholder' => 'Seleziona se è un robot',
            'tooltip' => 'Indica se è un bot automatizzato',
            'helper_text' => 'Specifica se il dispositivo è utilizzato da un robot o sistema automatizzato',
            'help' => 'Indica se il dispositivo è un robot o bot automatizzato',
        ],
        'robot' => [
            'label' => 'Robot',
            'placeholder' => 'Inserisci il tipo di robot',
            'tooltip' => 'Tipo specifico di robot',
            'helper_text' => 'Nome o tipo del robot/crawler se il dispositivo è automatizzato',
            'help' => 'Tipo di robot se applicabile (Googlebot, Bingbot, etc.)',
        ],
        'is_desktop' => [
            'label' => 'È Desktop',
            'placeholder' => 'Seleziona se è desktop',
            'tooltip' => 'Dispositivo desktop o computer fisso',
            'helper_text' => 'Indica se si tratta di un computer desktop o workstation fissa',
            'help' => 'Indica se è un dispositivo desktop o computer fisso',
        ],
        'is_mobile' => [
            'label' => 'È Mobile',
            'placeholder' => 'Seleziona se è mobile',
            'tooltip' => 'Dispositivo mobile portatile',
            'helper_text' => 'Specifica se il dispositivo è mobile (smartphone, tablet o dispositivo portatile)',
            'help' => 'Indica se è un dispositivo mobile (smartphone o tablet)',
        ],
        'is_tablet' => [
            'label' => 'È Tablet',
            'placeholder' => 'Seleziona se è tablet',
            'tooltip' => 'Dispositivo tablet con schermo touch',
            'helper_text' => 'Indica se si tratta di un tablet o dispositivo con schermo di medie dimensioni',
            'help' => 'Indica se è un tablet o dispositivo con schermo di medie dimensioni',
        ],
        'is_phone' => [
            'label' => 'È Telefono',
            'placeholder' => 'Seleziona se è telefono',
            'tooltip' => 'Smartphone o telefono cellulare',
            'helper_text' => 'Specifica se il dispositivo è uno smartphone o telefono cellulare',
            'help' => 'Indica se è uno smartphone o telefono cellulare',
        ],
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'create' => [
            'label' => 'Crea Dispositivo',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Aggiungi un nuovo dispositivo al sistema',
            'modal' => [
                'heading' => 'Crea Nuovo Dispositivo',
                'description' => 'Inserisci i dettagli del nuovo dispositivo da aggiungere',
                'confirm' => 'Crea',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dispositivo creato con successo',
                'error' => 'Si è verificato un errore durante la creazione del dispositivo',
            ],
        ],
        'edit' => [
            'label' => 'Modifica Dispositivo',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica i dettagli del dispositivo selezionato',
            'modal' => [
                'heading' => 'Modifica Dispositivo',
                'description' => 'Aggiorna le informazioni del dispositivo',
                'confirm' => 'Salva modifiche',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dispositivo modificato con successo',
                'error' => 'Si è verificato un errore durante la modifica del dispositivo',
            ],
        ],
        'delete' => [
            'label' => 'Elimina Dispositivo',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina definitivamente il dispositivo dal sistema',
            'modal' => [
                'heading' => 'Elimina Dispositivo',
                'description' => 'Sei sicuro di voler eliminare questo dispositivo? Questa azione è irreversibile.',
                'confirm' => 'Elimina',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dispositivo eliminato con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione del dispositivo',
            ],
        ],
        'view' => [
            'label' => 'Visualizza Dispositivo',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza i dettagli del dispositivo',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionati',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina tutti i dispositivi selezionati',
            'modal' => [
                'heading' => 'Elimina Dispositivi Selezionati',
                'description' => 'Sei sicuro di voler eliminare tutti i dispositivi selezionati? Questa azione è irreversibile.',
                'confirm' => 'Elimina tutti',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dispositivi eliminati con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione dei dispositivi',
            ],
        ],
    ],
    // SECTIONS - ORGANIZZAZIONE FORM
    'sections' => [
        'device_info' => [
            'label' => 'Informazioni Dispositivo',
            'description' => 'Dettagli tecnici del dispositivo',
        ],
        'device_type' => [
            'label' => 'Tipo Dispositivo',
            'description' => 'Categoria e classificazione del dispositivo',
        ],
        'browser_info' => [
            'label' => 'Informazioni Browser',
            'description' => 'Dettagli del browser utilizzato',
            // FILTERS - RICERCA E FILTRI
        ],
    ],
    'filters' => [
        'platform' => [
            'label' => 'Piattaforma',
            'options' => [
                'ios' => 'iOS',
                'android' => 'Android',
                'windows' => 'Windows',
                'linux' => 'Linux',
                'macos' => 'macOS',
            ],
        ],
        'device_type' => [
            'label' => 'Tipo Dispositivo',
            'options' => [
                'desktop' => 'Desktop',
                'mobile' => 'Mobile',
                'tablet' => 'Tablet',
                'phone' => 'Telefono',
            ],
        ],
        'is_robot' => [
            'label' => 'Robot',
            'options' => [
                'yes' => 'Sì',
                'no' => 'No',
            ],
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
        'empty_state' => 'Nessun dispositivo trovato',
        'search_placeholder' => 'Cerca dispositivi...',
        'loading' => 'Caricamento dispositivi in corso...',
        // VALIDATION - MESSAGGI DI VALIDAZIONE
        'validation' => [
            'uuid_required' => 'L\'UUID è obbligatorio',
            'uuid_unique' => 'Questo UUID è già in uso',
            'platform_required' => 'La piattaforma è obbligatoria',
            'device_required' => 'Il nome del dispositivo è obbligatorio',
            'languages_array' => 'Le lingue devono essere un array',
        ],
        // OPTIONS - OPZIONI E VALORI PREDEFINITI
        'options' => [
            'platforms' => [
                'ios' => 'iOS',
                'android' => 'Android',
                'windows' => 'Windows',
                'linux' => 'Linux',
                'macos' => 'macOS',
            ],
            'device_types' => [
                'desktop' => 'Desktop',
                'mobile' => 'Mobile',
                'tablet' => 'Tablet',
                'phone' => 'Telefono',
            ],
            'boolean_options' => [
                'yes' => 'Sì',
                'no' => 'No',
            ],
        ],
        'total_devices' => 'Totale dispositivi: :count',
    ],
];
