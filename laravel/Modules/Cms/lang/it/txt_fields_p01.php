<?php

declare(strict_types=1);

// Cms translations — LangServiceProvider SSoT (never ->label() in Filament PHP).
// Canon: Modules/Cms/docs/wiki — domain i18n only.
// File: lang/it/txt_fields_p01.php
// Cms nested fields split — claude-audit <500 LOC
return [
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    // Cms — translation keys (no business logic).
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo principale',
            'help' => 'Titolo principale',
            'helper_text' => 'Titolo che apparirà come intestazione principale',
            'tooltip' => '',
            'description' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'testo-per-url',
            'help' => 'Versione dell\'URL del titolo (solo lettere minuscole, trattini e numeri]',
            'helper_text' => 'URL SEO-friendly generato automaticamente dal titolo',
            'tooltip' => '',
            'description' => '',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo',
            'placeholder' => 'Inserisci un sottotitolo',
            'help' => 'Sottotitolo opzionale',
            'helper_text' => 'Testo secondario che accompagna il titolo principale',
            'tooltip' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Testo descrittivo',
            'helper_text' => 'Descrizione utilizzata per SEO e preview social',
            'tooltip' => '',
            'description' => '',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Scrivi il contenuto principale qui...',
            'helper_text' => 'Contenuto principale dell\'articolo o pagina',
            'tooltip' => '',
            'description' => '',
        ],
        'text' => [
            'label' => 'Testo',
            'placeholder' => 'Inserisci il testo',
            'helper_text' => 'Contenuto testuale semplice senza formattazione',
            'tooltip' => '',
            'description' => '',
        ],
        'image' => [
            'label' => 'Immagine',
            'help' => 'Carica un\'immagine',
            'placeholder' => 'Seleziona o carica immagine',
            'helper_text' => 'Immagine principale associata al contenuto',
            'tooltip' => '',
            'description' => '',
        ],
        'alt' => [
            'label' => 'Testo Alternativo',
            'placeholder' => 'Descrizione immagine per accessibilità',
            'helper_text' => 'Testo letto dagli screen reader per utenti non vedenti',
            'tooltip' => '',
            'description' => '',
        ],
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => '100%, 500px, auto',
            'helper_text' => 'Larghezza dell\'elemento in pixel, percentuale o auto',
            'tooltip' => '',
            'description' => '',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => '300px, auto, 50vh',
            'helper_text' => 'Altezza dell\'elemento in pixel, percentuale o viewport',
            'tooltip' => '',
            'description' => '',
        ],
        'style' => [
            'label' => 'Stile',
            'help' => 'Stile di visualizzazione',
            'placeholder' => 'Seleziona stile di visualizzazione',
            'helper_text' => 'Stile predefinito per la visualizzazione dell\'elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'size' => [
            'label' => 'Dimensione',
            'placeholder' => 'Piccolo, Medio, Grande',
            'helper_text' => 'Dimensione relativa dell\'elemento',
            'tooltip' => '',
            'description' => '',
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
            'tooltip' => '',
            'description' => '',
        ],
        'gap' => [
            'label' => 'Spaziatura',
            'placeholder' => '10px, 1rem, small',
            'helper_text' => 'Spazio tra gli elementi',
            'tooltip' => '',
            'description' => '',
        ],
        'orientation' => [
            'label' => 'Orientamento',
            'placeholder' => 'Orizzontale, Verticale',
            'helper_text' => 'Orientamento del layout o degli elementi',
            'tooltip' => '',
            'description' => '',
        ],
        'background_color' => [
            'label' => 'Colore di sfondo',
            'help' => 'Seleziona un colore di sfondo',
            'placeholder' => '#FFFFFF, bianco, transparent',
            'helper_text' => 'Colore di sfondo dell\'elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'text_color' => [
            'label' => 'Colore Testo',
            'placeholder' => '#000000, nero, inherit',
            'helper_text' => 'Colore del testo dell\'elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'cta_color' => [
            'label' => 'Colore CTA',
            'placeholder' => '#007BFF, blu, primary',
            'helper_text' => 'Colore dei pulsanti call-to-action',
            'tooltip' => '',
            'description' => '',
        ],
        'items' => [
            'label' => 'Elementi',
            'help' => 'Elenco di elementi',
            'placeholder' => 'Aggiungi elementi alla lista',
            'helper_text' => 'Lista di elementi che compongono menu o collezioni',
            'tooltip' => '',
            'description' => '',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Testo dell\'etichetta',
            'helper_text' => 'Testo visibile per link, pulsanti o elementi interattivi',
            'tooltip' => '',
            'description' => '',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://esempio.com',
            'help' => 'Inserisci un URL valido (inizia con http:// o https://]',
            'helper_text' => 'Indirizzo web completo di destinazione',
            'tooltip' => '',
            'description' => '',
        ],
        'target' => [
            'label' => 'Destinazione',
            'placeholder' => '_blank, _self, _parent, _top',
            'helper_text' => 'Come aprire il collegamento (stessa finestra o nuova]',
            'tooltip' => '',
            'description' => '',
        ],
        'icon' => [
            'label' => 'Icona',
            'help' => 'Seleziona un\'icona da visualizzare',
            'placeholder' => 'Seleziona icona rappresentativa',
            'helper_text' => 'Icona da mostrare accanto al testo o come elemento standalone',
            'tooltip' => '',
            'description' => '',
        ],
        'view' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template di visualizzazione',
            'helper_text' => 'Template Blade utilizzato per renderizzare questo elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Categoria o tipologia',
            'helper_text' => 'Tipo di contenuto o categoria dell\'elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'level' => [
            'label' => 'Livello',
            'placeholder' => 'Livello gerarchico (1-6]',
            'helper_text' => 'Livello di importanza nella gerarchia del contenuto',
            'tooltip' => '',
            'description' => '',
        ],
        'children' => [
            'label' => 'Elementi Figli',
            'placeholder' => 'Elementi nested o subordinati',
            'helper_text' => 'Elementi contenuti o dipendenti da questo elemento',
            'tooltip' => '',
            'description' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@dominio.com',
            'help' => 'Indirizzo email valido',
            'helper_text' => 'Indirizzo email principale per contatti',
            'tooltip' => '',
            'description' => '',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 000 000 0000',
            'helper_text' => 'Numero di telefono principale',
            'tooltip' => '',
            'description' => '',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma 1, 00100 Roma RM',
            'help' => 'Indirizzo completo',
            'helper_text' => 'Indirizzo fisico completo dell\'azienda',
            'tooltip' => '',
            'description' => '',
        ],
    ],
];
