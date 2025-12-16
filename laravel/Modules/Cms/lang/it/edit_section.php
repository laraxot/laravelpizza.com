<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome Sezione',
            'placeholder' => 'Nome identificativo della sezione',
            'help' => 'Nome interno per identificare questa sezione',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'nome-sezione',
            'help' => 'Identificativo univoco della sezione (solo lettere minuscole, trattini e numeri)',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'help' => 'Titolo della sezione',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Testo descrittivo della sezione',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Contenuto principale della sezione',
            'helper_text' => 'Testo e media che compongono la sezione',
        ],
        'view' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template di visualizzazione',
            'helper_text' => 'Template utilizzato per renderizzare questa sezione',
        ],
        'blocks' => [
            'label' => 'Blocchi',
            'help' => 'Blocchi di contenuto della sezione',
            'placeholder' => 'Aggiungi blocchi alla sezione',
            'helper_text' => 'Blocchi di contenuto che compongono la sezione',
        ],
        // Company Information
        'company_name' => [
            'label' => 'Ragione Sociale',
            'placeholder' => 'Azienda S.p.A.',
            'help' => 'Nome completo dell\'azienda',
            'helper_text' => 'Ragione sociale dell\'azienda',
        ],
        'logo' => [
            'label' => 'Logo',
            'help' => 'Carica il file del logo',
            'placeholder' => 'Seleziona logo aziendale',
            'helper_text' => 'Logo rappresentativo dell\'azienda',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@dominio.com',
            'help' => 'Indirizzo email valido',
            'helper_text' => 'Indirizzo email principale',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 06 1234567',
            'help' => 'Numero di telefono con prefisso internazionale',
            'helper_text' => 'Numero di telefono di contatto',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma 1, 00100 Roma RM',
            'help' => 'Indirizzo completo',
            'helper_text' => 'Indirizzo fisico dell\'azienda',
        ],
        'copyright' => [
            'label' => 'Copyright',
            'placeholder' => ' 2023 Nome Azienda',
            'help' => 'Testo del copyright',
            'helper_text' => 'Testo di copyright da visualizzare',
        ],
        // Navigation & Links
        'links' => [
            'label' => 'Collegamenti',
            'placeholder' => 'Aggiungi link di navigazione',
            'helper_text' => 'Lista di collegamenti per la navigazione',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Testo del link',
            'helper_text' => 'Testo visibile per il collegamento',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://esempio.com',
            'help' => 'Inserisci un URL valido (inizia con http:// o https://)',
            'helper_text' => 'Indirizzo web di destinazione',
        ],
        'target' => [
            'label' => 'Destinazione',
            'placeholder' => '_blank per nuova finestra',
            'helper_text' => 'Come aprire il collegamento',
        ],
        'icon' => [
            'label' => 'Icona',
            'help' => 'Seleziona un\'icona da visualizzare',
            'placeholder' => 'Seleziona icona',
            'helper_text' => 'Icona da associare al link',
        ],
        // Social Media
        'social_links' => [
            'label' => 'Social Media',
            'help' => 'Collegamenti ai profili social',
            'placeholder' => 'Aggiungi profili social',
            'helper_text' => 'Collegamenti ai profili social dell\'azienda',
        ],
        'platform' => [
            'label' => 'Piattaforma',
            'help' => 'Seleziona la piattaforma social',
            'placeholder' => 'Facebook, Instagram, LinkedIn',
            'helper_text' => 'Nome della piattaforma social',
        ],
        // Visual Elements
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => 'Larghezza in px o %',
            'helper_text' => 'Larghezza dell\'elemento visivo',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => 'es. auto o 200px',
            'help' => 'Altezza in pixel o lasciare su auto',
            'helper_text' => 'Altezza dell\'elemento visivo',
        ],
        'cta_color' => [
            'label' => 'Colore CTA',
            'help' => 'Colore per i pulsanti e le azioni principali',
            'placeholder' => '#FF5733 o nome colore',
            'helper_text' => 'Colore dei pulsanti call-to-action',
        ],
        'text_color' => [
            'label' => 'Colore Testo',
            'help' => 'Colore del testo principale',
            'placeholder' => '#333333 o nome colore',
            'helper_text' => 'Colore del testo nella sezione',
        ],
        // Media Elements
        'caption' => [
            'label' => 'Didascalia',
            'placeholder' => 'Descrizione dell\'immagine',
            'helper_text' => 'Testo descrittivo per immagini',
        ],
        'video' => [
            'label' => 'Video',
            'placeholder' => 'URL del video',
            'helper_text' => 'Video da incorporare nella sezione',
        ],
        'img_uuid' => [
            'label' => 'ID Immagine',
            'placeholder' => 'UUID dell\'immagine',
            'helper_text' => 'Identificatore univoco dell\'immagine',
        ],
        // Content Elements
        'level' => [
            'label' => 'Livello',
            'placeholder' => 'Livello gerarchico',
            'helper_text' => 'Livello di profondità nella struttura',
        ],
        'text' => [
            'label' => 'Testo',
            'placeholder' => 'Contenuto testuale',
            'helper_text' => 'Testo semplice della sezione',
        ],
        // Form Messages
        'error_message' => [
            'label' => 'Messaggio Errore',
            'placeholder' => 'Testo per errori',
            'helper_text' => 'Messaggio mostrato in caso di errore',
        ],
        'success_message' => [
            'label' => 'Messaggio Successo',
            'placeholder' => 'Testo per successo',
            'helper_text' => 'Messaggio mostrato quando l\'operazione è riuscita',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva modifiche',
            'success' => 'Sezione salvata con successo',
            'error' => 'Errore durante il salvataggio della sezione',
            'confirmation' => 'Vuoi salvare le modifiche alla sezione?',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'confirmation' => 'Sei sicuro di voler annullare? Le modifiche andranno perse.',
        ],
        'activeLocale' => [
            'label' => 'Lingua Attiva',
            'description' => 'Seleziona la lingua per le traduzioni della sezione',
        ],
        'add_block' => 'Aggiungi blocco',
        'remove_block' => 'Rimuovi blocco',
    ],
    'sections' => [
        'basic_info' => [
            'label' => 'Informazioni Base',
            'description' => 'Dati fondamentali della sezione',
        ],
        'content' => [
            'label' => 'Contenuto',
            'description' => 'Elementi testuali e multimediali',
        ],
        'styling' => [
            'label' => 'Stile',
            'description' => 'Personalizzazione visiva',
        ],
        'company_info' => [
            'label' => 'Info Azienda',
            'description' => 'Dati aziendali e contatti',
        ],
        'navigation' => [
            'label' => 'Navigazione',
            'description' => 'Link e menu di navigazione',
        ],
        'social' => [
            'label' => 'Social Media',
            'description' => 'Profili e collegamenti social',
        ],
        'settings' => [
            'label' => 'Impostazioni',
            'description' => 'Configurazioni generali della sezione',
        ],
        'seo' => [
            'label' => 'SEO',
            'description' => 'Ottimizzazione per motori di ricerca',
        ],
    ],
    'messages' => [
        'section_updated' => 'Sezione aggiornata con successo',
        'section_update_error' => 'Errore durante l\'aggiornamento della sezione',
        'validation_errors' => 'Controlla i campi evidenziati in rosso',
        'unsaved_changes' => 'Hai modifiche non salvate in questa sezione',
        'confirm_navigation' => 'Vuoi davvero lasciare questa pagina? Le modifiche non salvate andranno perse.',
        'saved' => 'Sezione salvata con successo',
        'error' => 'Si è verificato un errore durante il salvataggio',
        'confirm_delete' => 'Sei sicuro di voler eliminare questa sezione?',
    ],
    'validation' => [
        'required' => 'Questo campo è obbligatorio',
        'slug_exists' => 'Questo slug è già in uso',
        'min' => 'Il valore deve essere almeno :min',
    ],
];
