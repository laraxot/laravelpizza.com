<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo principale',
            'help' => 'Titolo principale',
            'helper_text' => 'Titolo che apparirà come intestazione principale',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'testo-per-url',
            'help' => 'Versione dell\'URL del titolo (solo lettere minuscole, trattini e numeri)',
            'helper_text' => 'URL SEO-friendly generato automaticamente dal titolo',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo',
            'placeholder' => 'Inserisci un sottotitolo',
            'help' => 'Sottotitolo opzionale',
            'helper_text' => 'Testo secondario che accompagna il titolo principale',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Testo descrittivo',
            'helper_text' => 'Descrizione utilizzata per SEO e preview social',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Scrivi il contenuto principale qui...',
            'helper_text' => 'Contenuto principale dell\'articolo o pagina',
        ],
        'text' => [
            'label' => 'Testo',
            'placeholder' => 'Inserisci il testo',
            'helper_text' => 'Contenuto testuale semplice senza formattazione',
        ],
        'image' => [
            'label' => 'Immagine',
            'help' => 'Carica un\'immagine',
            'placeholder' => 'Seleziona o carica immagine',
            'helper_text' => 'Immagine principale associata al contenuto',
        ],
        'alt' => [
            'label' => 'Testo Alternativo',
            'placeholder' => 'Descrizione immagine per accessibilità',
            'helper_text' => 'Testo letto dagli screen reader per utenti non vedenti',
        ],
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => '100%, 500px, auto',
            'helper_text' => 'Larghezza dell\'elemento in pixel, percentuale o auto',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => '300px, auto, 50vh',
            'helper_text' => 'Altezza dell\'elemento in pixel, percentuale o viewport',
        ],
        'style' => [
            'label' => 'Stile',
            'help' => 'Stile di visualizzazione',
            'placeholder' => 'Seleziona stile di visualizzazione',
            'helper_text' => 'Stile predefinito per la visualizzazione dell\'elemento',
        ],
        'size' => [
            'label' => 'Dimensione',
            'placeholder' => 'Piccolo, Medio, Grande',
            'helper_text' => 'Dimensione relativa dell\'elemento',
        ],
        'alignment' => [
            'label' => 'Allineamento',
            'help' => 'Allineamento del testo',
            'options' => [
                'left' => 'Sinistra',
                'center' => 'Centro',
                'right' => 'Destra',
                'justify' => 'Giustificato',
            ],
            'placeholder' => 'Sinistra, Centro, Destra',
            'helper_text' => 'Allineamento del contenuto all\'interno dell\'elemento',
        ],
        'gap' => [
            'label' => 'Spaziatura',
            'placeholder' => '10px, 1rem, small',
            'helper_text' => 'Spazio tra gli elementi',
        ],
        'orientation' => [
            'label' => 'Orientamento',
            'placeholder' => 'Orizzontale, Verticale',
            'helper_text' => 'Orientamento del layout o degli elementi',
        ],
        'background_color' => [
            'label' => 'Colore di sfondo',
            'help' => 'Seleziona un colore di sfondo',
            'placeholder' => '#FFFFFF, bianco, transparent',
            'helper_text' => 'Colore di sfondo dell\'elemento',
        ],
        'text_color' => [
            'label' => 'Colore Testo',
            'placeholder' => '#000000, nero, inherit',
            'helper_text' => 'Colore del testo dell\'elemento',
        ],
        'cta_color' => [
            'label' => 'Colore CTA',
            'placeholder' => '#007BFF, blu, primary',
            'helper_text' => 'Colore dei pulsanti call-to-action',
        ],
        'items' => [
            'label' => 'Elementi',
            'help' => 'Elenco di elementi',
            'placeholder' => 'Aggiungi elementi alla lista',
            'helper_text' => 'Lista di elementi che compongono menu o collezioni',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Testo dell\'etichetta',
            'helper_text' => 'Testo visibile per link, pulsanti o elementi interattivi',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://esempio.com',
            'help' => 'Inserisci un URL valido (inizia con http:// o https://)',
            'helper_text' => 'Indirizzo web completo di destinazione',
        ],
        'target' => [
            'label' => 'Destinazione',
            'placeholder' => '_blank, _self, _parent, _top',
            'helper_text' => 'Come aprire il collegamento (stessa finestra o nuova)',
        ],
        'icon' => [
            'label' => 'Icona',
            'help' => 'Seleziona un\'icona da visualizzare',
            'placeholder' => 'Seleziona icona rappresentativa',
            'helper_text' => 'Icona da mostrare accanto al testo o come elemento standalone',
        ],
        'view' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template di visualizzazione',
            'helper_text' => 'Template Blade utilizzato per renderizzare questo elemento',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Categoria o tipologia',
            'helper_text' => 'Tipo di contenuto o categoria dell\'elemento',
        ],
        'level' => [
            'label' => 'Livello',
            'placeholder' => 'Livello gerarchico (1-6)',
            'helper_text' => 'Livello di importanza nella gerarchia del contenuto',
        ],
        'children' => [
            'label' => 'Elementi Figli',
            'placeholder' => 'Elementi nested o subordinati',
            'helper_text' => 'Elementi contenuti o dipendenti da questo elemento',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@dominio.com',
            'help' => 'Indirizzo email valido',
            'helper_text' => 'Indirizzo email principale per contatti',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 000 000 0000',
            'helper_text' => 'Numero di telefono principale',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma 1, 00100 Roma RM',
            'help' => 'Indirizzo completo',
            'helper_text' => 'Indirizzo fisico completo dell\'azienda',
        ],
        'map_url' => [
            'label' => 'Link Mappa',
            'placeholder' => 'https://maps.google.com/...',
            'helper_text' => 'Link a Google Maps o altro servizio di mappe',
        ],
        'logo' => [
            'label' => 'Logo',
            'placeholder' => 'Carica logo aziendale',
            'helper_text' => 'Logo rappresentativo dell\'azienda o brand',
        ],
        'copyright' => [
            'label' => 'Copyright',
            'placeholder' => '2024 Nome Azienda. Tutti i diritti riservati.',
            'helper_text' => 'Testo di copyright da visualizzare nel footer',
        ],
        'button_text' => [
            'label' => 'Testo del pulsante',
            'placeholder' => 'Scopri di più',
            'help' => 'Testo visualizzato sul pulsante',
            'helper_text' => 'Testo che apparirà sul pulsante',
        ],
        'button_link' => [
            'label' => 'Collegamento del pulsante',
            'placeholder' => 'https://esempio.com',
            'help' => 'URL di destinazione del pulsante',
            'helper_text' => 'URL di destinazione quando si clicca il pulsante',
        ],
        'cta_text' => [
            'label' => 'Testo Call-to-Action',
            'placeholder' => 'Inizia ora, Contattaci oggi',
            'helper_text' => 'Testo persuasivo per invitare all\'azione',
        ],
        'cta_link' => [
            'label' => 'Collegamento CTA',
            'placeholder' => 'https://esempio.com',
            'help' => 'URL di destinazione per la call-to-action',
            'helper_text' => 'URL della pagina di destinazione per la CTA',
        ],
        'social_links' => [
            'label' => 'Link Social',
            'placeholder' => 'Aggiungi profili social media',
            'helper_text' => 'Collegamenti ai profili social dell\'azienda',
        ],
        'platform' => [
            'label' => 'Piattaforma',
            'placeholder' => 'Facebook, Instagram, LinkedIn, Twitter',
            'helper_text' => 'Nome della piattaforma social media',
        ],
        'links' => [
            'label' => 'Collegamenti',
            'placeholder' => 'Lista di link di navigazione',
            'helper_text' => 'Collezione di collegamenti per menu o footer',
        ],
        'stats' => [
            'label' => 'Statistiche',
            'placeholder' => 'Dati numerici da evidenziare',
            'helper_text' => 'Statistiche o metriche da mostrare',
        ],
        'number' => [
            'label' => 'Numero',
            'placeholder' => 'Valore numerico',
            'helper_text' => 'Valore numerico per contatori o statistiche',
        ],
        'sections' => [
            'label' => 'Sezioni',
            'help' => 'Elenco delle sezioni',
            'placeholder' => 'Sezioni che compongono la pagina',
            'helper_text' => 'Sezioni principali che strutturano il contenuto',
        ],
        'content_blocks' => [
            'label' => 'Blocchi Contenuto',
            'placeholder' => 'Blocchi di contenuto principale',
            'helper_text' => 'Blocchi che compongono il corpo principale della pagina',
        ],
        'sidebar_blocks' => [
            'label' => 'Blocchi Sidebar',
            'placeholder' => 'Contenuti della barra laterale',
            'helper_text' => 'Elementi da visualizzare nella barra laterale',
        ],
        'footer_blocks' => [
            'label' => 'Blocchi Footer',
            'placeholder' => 'Contenuti del piè di pagina',
            'helper_text' => 'Elementi da includere nel footer del sito',
        ],
        'placeholder' => [
            'label' => 'Placeholder',
            'placeholder' => 'Testo segnaposto per campi input',
            'helper_text' => 'Testo mostrato nei campi vuoti come suggerimento',
        ],
        'success_message' => [
            'label' => 'Messaggio Successo',
            'placeholder' => 'Operazione completata con successo',
            'helper_text' => 'Messaggio mostrato quando un\'operazione ha successo',
        ],
        'error_message' => [
            'label' => 'Messaggio Errore',
            'placeholder' => 'Si è verificato un errore',
            'helper_text' => 'Messaggio mostrato in caso di errore',
        ],
        'background' => [
            'label' => 'Sfondo',
            'placeholder' => 'Immagine o colore di sfondo',
            'helper_text' => 'Sfondo della sezione (immagine, colore o gradiente)',
        ],
        'buttons' => [
            'label' => 'Pulsanti',
            'placeholder' => 'Pulsanti di azione per l\'utente',
            'helper_text' => 'Collezione di pulsanti per interazioni utente',
        ],
        'class' => [
            'label' => 'Classe CSS',
            'placeholder' => 'custom-class another-class',
            'helper_text' => 'Classi CSS personalizzate per styling avanzato',
        ],
        'link' => [
            'label' => 'Collegamento',
            'placeholder' => 'https://link-destinazione.it',
            'helper_text' => 'URL generico di collegamento',
        ],
        'ratio' => [
            'label' => 'Proporzioni',
            'placeholder' => '16:9, 4:3, 1:1, 21:9',
            'helper_text' => 'Rapporto di proporzione per immagini e video',
        ],
        'caption' => [
            'label' => 'Didascalia',
            'placeholder' => 'Didascalia per immagine o video',
            'helper_text' => 'Testo descrittivo mostrato sotto contenuti multimediali',
        ],
        'img_uuid' => [
            'label' => 'ID Immagine',
            'placeholder' => 'UUID dell\'immagine',
            'helper_text' => 'Identificatore univoco dell\'immagine nel sistema',
        ],
        'gallery' => [
            'label' => 'Galleria',
            'placeholder' => 'Collezione di immagini',
            'helper_text' => 'Galleria di immagini correlate',
        ],
        'version' => [
            'label' => 'Versione',
            'placeholder' => '1.0.0, v2.1, beta',
            'helper_text' => 'Versione del contenuto o componente',
        ],
        'method' => [
            'label' => 'Metodo',
            'placeholder' => 'GET, POST, PUT, DELETE',
            'helper_text' => 'Metodo HTTP per form o richieste API',
        ],
        'video' => [
            'label' => 'Video',
            'placeholder' => 'URL video YouTube/Vimeo o carica file',
            'helper_text' => 'Video da incorporare o collegare',
        ],
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva',
            'success' => 'Contenuto salvato con successo',
            'error' => 'Errore durante il salvataggio del contenuto',
            'confirmation' => 'Vuoi salvare le modifiche apportate?',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'confirmation' => 'Sei sicuro di voler annullare? Tutte le modifiche non salvate andranno perse.',
        ],
        'activeLocale' => [
            'label' => 'Lingua Attiva',
            'description' => 'Seleziona la lingua per la traduzione del contenuto',
            'help' => 'Modifica la lingua di editing per contenuti multilingua',
        ],
    ],
    'sections' => [
        'content' => [
            'label' => 'Contenuto',
            'description' => 'Gestione del contenuto principale',
        ],
        'media' => [
            'label' => 'Media',
            'description' => 'Immagini, video e contenuti multimediali',
        ],
        'design' => [
            'label' => 'Design',
            'description' => 'Aspetto visivo e layout',
        ],
        'navigation' => [
            'label' => 'Navigazione',
            'description' => 'Menu, link e struttura di navigazione',
        ],
        'company' => [
            'label' => 'Azienda',
            'description' => 'Informazioni aziendali e contatti',
        ],
        'social' => [
            'label' => 'Social Media',
            'description' => 'Profili e collegamenti social',
        ],
        'cta' => [
            'label' => 'Call-to-Action',
            'description' => 'Pulsanti e inviti all\'azione',
        ],
        'structure' => [
            'label' => 'Struttura',
            'description' => 'Layout e organizzazione della pagina',
        ],
        'advanced' => [
            'label' => 'Avanzato',
            'description' => 'Impostazioni tecniche e personalizzazioni',
        ],
    ],
    'messages' => [
        'content_saved' => 'Contenuto salvato con successo',
        'save_error' => 'Si è verificato un errore durante il salvataggio',
        'validation_failed' => 'Alcuni campi contengono errori. Controlla e riprova.',
        'unsaved_changes' => 'Hai modifiche non salvate',
        'confirm_navigation' => 'Vuoi davvero lasciare questa pagina? Le modifiche non salvate andranno perse.',
        'loading_content' => 'Caricamento contenuto in corso...',
        'processing_save' => 'Salvataggio in corso...',
        'image_upload_success' => 'Immagine caricata con successo',
        'image_upload_error' => 'Errore durante il caricamento dell\'immagine',
        'video_upload_success' => 'Video caricato con successo',
        'video_upload_error' => 'Errore durante il caricamento del video',
    ],
    'validation' => [
        'title_required' => 'Der Titel ist erforderlich',
        'slug_unique' => 'Questo slug è già in uso',
        'email_format' => 'Inserisci un indirizzo email valido',
        'url_format' => 'Inserisci un URL valido',
        'phone_format' => 'Inserisci un numero di telefono valido',
        'image_size' => 'L\'immagine deve essere inferiore a 5MB',
        'video_format' => 'Formato video non supportato',
        'required_field' => 'Dieses Feld ist erforderlich',
        'max_length' => 'Il testo è troppo lungo (massimo :max caratteri)',
        'min_length' => 'Il testo è troppo corto (minimo :min caratteri)',
    ],
];
