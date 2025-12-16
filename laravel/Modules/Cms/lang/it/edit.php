<?php

declare(strict_types=1);

return [
    'fields' => [
        // Content Fields
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'help' => 'Titolo principale della pagina o del contenuto',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'testo-per-url',
            'help' => 'Versione dell\'URL del titolo (solo lettere minuscole, trattini e numeri)',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Scrivi qui il contenuto...',
            'helper_text' => 'Contenuto principale dell\'elemento',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Breve descrizione',
            'helper_text' => 'Descrizione per SEO e anteprima',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo',
            'placeholder' => 'Inserisci un sottotitolo',
            'help' => 'Sottotitolo opzionale',
        ],
        'text' => [
            'label' => 'Testo',
            'placeholder' => 'Inserisci il testo',
            'help' => 'Testo da visualizzare',
        ],
        'level' => [
            'label' => 'Livello',
            'help' => 'Livello gerarchico del contenuto',
        ],
        // Visual & Media
        'image' => [
            'label' => 'Immagine',
            'help' => 'Carica un\'immagine',
        ],
        'gallery' => [
            'label' => 'Galleria',
            'help' => 'Raccolta di immagini',
        ],
        'video' => [
            'label' => 'Video',
            'help' => 'Incorpora un video',
        ],
        'img_uuid' => [
            'label' => 'ID Immagine',
            'help' => 'Identificativo univoco dell\'immagine',
        ],
        'alt' => [
            'label' => 'Testo Alternativo',
            'placeholder' => 'Descrizione immagine',
            'helper_text' => 'Testo alternativo per accessibilità',
        ],
        'caption' => [
            'label' => 'Didascalia',
            'placeholder' => 'Inserisci una didascalia',
            'help' => 'Testo descrittivo sotto l\'immagine',
        ],
        'ratio' => [
            'label' => 'Proporzioni',
            'placeholder' => '16:9, 4:3, 1:1',
            'helper_text' => 'Rapporto di proporzione per il ridimensionamento',
        ],
        // Styling & Layout
        'background' => [
            'label' => 'Sfondo',
            'help' => 'Immagine o colore di sfondo',
        ],
        'class' => [
            'label' => 'Classe CSS',
            'placeholder' => 'es. btn btn-primary',
            'help' => 'Classi CSS aggiuntive',
        ],
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => '100%, 500px, auto',
            'helper_text' => 'Larghezza dell\'elemento',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => '300px, auto, 50vh',
            'helper_text' => 'Altezza dell\'elemento',
        ],
        'src' => [
            'label' => 'Sorgente',
            'placeholder' => 'URL o percorso del file',
            'helper_text' => 'Percorso della risorsa multimediale',
        ],
        // Interaction Elements
        'buttons' => [
            'label' => 'Pulsanti',
            'help' => 'Elenco dei pulsanti da visualizzare',
        ],
        'link' => [
            'label' => 'Collegamento',
            'placeholder' => 'https://esempio.it',
            'helper_text' => 'URL di destinazione',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://esempio.com',
            'help' => 'Inserisci un URL valido (inizia con http:// o https://)',
        ],
        'target' => [
            'label' => 'Destinazione',
            'placeholder' => '_blank, _self, _parent',
            'helper_text' => 'Come aprire il collegamento',
        ],
        'button_text' => [
            'label' => 'Testo Pulsante',
            'placeholder' => 'Clicca qui',
            'helper_text' => 'Testo visualizzato sul pulsante',
        ],
        'button_link' => [
            'label' => 'Link Pulsante',
            'placeholder' => 'https://destinazione.it',
            'helper_text' => 'URL di destinazione del pulsante',
        ],
        // Navigation & Structure
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Nome dell\'elemento',
            'helper_text' => 'Etichetta identificativa dell\'elemento',
        ],
        'items' => [
            'label' => 'Elementi',
            'placeholder' => 'Lista di elementi',
            'helper_text' => 'Elementi che compongono lista o menu',
        ],
        'links' => [
            'label' => 'Collegamenti',
            'placeholder' => 'Lista collegamenti',
            'helper_text' => 'Collezione di link di navigazione',
        ],
        'social_links' => [
            'label' => 'Link Social',
            'placeholder' => 'Profili social media',
            'helper_text' => 'Collegamenti ai profili social dell\'azienda',
        ],
        'platform' => [
            'label' => 'Piattaforma',
            'placeholder' => 'Facebook, Instagram, Twitter',
            'helper_text' => 'Nome della piattaforma social media',
        ],
        'icon' => [
            'label' => 'Icona',
            'placeholder' => 'Seleziona icona',
            'helper_text' => 'Icona rappresentativa dell\'elemento',
        ],
        // Company & Contact
        'company_name' => [
            'label' => 'Nome Azienda',
            'placeholder' => 'La Tua Azienda S.r.l.',
            'helper_text' => 'Ragione sociale dell\'azienda',
        ],
        'logo' => [
            'label' => 'Logo',
            'placeholder' => 'Carica logo aziendale',
            'helper_text' => 'Logo rappresentativo dell\'azienda',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'contatti@azienda.it',
            'helper_text' => 'Indirizzo email di contatto',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 000 000 0000',
            'helper_text' => 'Numero di telefono principale',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma, 123 - 00100 Roma',
            'helper_text' => 'Indirizzo fisico completo',
        ],
        // Technical Fields
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Tipologia elemento',
            'helper_text' => 'Categoria o tipo di contenuto',
        ],
        'view' => [
            'label' => 'Vista',
            'help' => 'Template di visualizzazione da utilizzare',
        ],
        'method' => [
            'label' => 'Metodo',
            'help' => 'Metodo HTTP da utilizzare',
        ],
        'version' => [
            'label' => 'Versione',
            'help' => 'Numero di versione',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'placeholder' => '',
            'helper_text' => 'Rendi questo elemento visibile pubblicamente',
        ],
        'number' => [
            'label' => 'Numero',
            'placeholder' => 'Valore numerico',
            'helper_text' => 'Valore numerico per statistiche o contatori',
        ],
        // Block Management
        'content_blocks' => [
            'label' => 'Blocchi Contenuto',
            'placeholder' => 'Aggiungi sezioni di contenuto',
            'helper_text' => 'Blocchi che compongono il contenuto principale',
        ],
        'sidebar_blocks' => [
            'label' => 'Blocchi Sidebar',
            'help' => 'Contenuti della barra laterale',
        ],
        'footer_blocks' => [
            'label' => 'Blocchi Footer',
            'placeholder' => 'Contenuti del footer',
            'helper_text' => 'Elementi da includere nel piè di pagina',
        ],
        'sections' => [
            'label' => 'Sezioni',
            'placeholder' => 'Gestisci sezioni della pagina',
            'helper_text' => 'Sezioni principali che compongono la pagina',
        ],
    ],
    'actions' => [
        'save' => 'Salva modifiche',
        'save_and_close' => 'Salva e chiudi',
        'cancel' => 'Annulla',
        'preview' => 'Anteprima',
        'add_block' => 'Aggiungi blocco',
        'remove_block' => 'Rimuovi blocco',
    ],
    'messages' => [
        'saved' => 'Modifiche salvate con successo',
        'error' => 'Si è verificato un errore durante il salvataggio',
        'confirm_delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'unsaved_changes' => 'Hai modifiche non salvate',
    ],
    'validation' => [
        'required' => 'Questo campo è obbligatorio',
        'slug_exists' => 'Questo slug è già in uso',
        'invalid_url' => 'Inserisci un URL valido',
        'min' => 'Il valore deve essere almeno :min',
        'max' => 'Il valore non può superare :max',
    ],
    'sections' => [
        'content' => 'Contenuto',
        'media' => 'Media',
        'seo' => 'SEO',
        'settings' => 'Impostazioni',
    ],
];
