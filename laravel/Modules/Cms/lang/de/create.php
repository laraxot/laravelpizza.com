<?php

declare(strict_types=1);

return [
    'fields' => [
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'help' => 'Il titolo principale della pagina o della sezione',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'testo-per-url',
            'help' => 'Versione dell\'URL del titolo (solo lettere minuscole, trattini e numeri)',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Scrivi il contenuto qui...',
            'helper_text' => 'Il contenuto principale della pagina o sezione',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'help' => 'Testo descrittivo del contenuto',
        ],
        'type' => [
            'label' => 'Tipo',
            'help' => 'Seleziona il tipo di contenuto',
        ],
        'view' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona template',
            'helper_text' => 'Template di visualizzazione per questo contenuto',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Attiva/disattiva questo elemento',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Etichetta del pulsante/collegamento',
            'help' => 'Testo visualizzato per il pulsante o il collegamento',
        ],
        'version' => [
            'label' => 'Versione',
            'placeholder' => '1.0.0',
            'helper_text' => 'Versione del contenuto per tracking modifiche',
        ],
        'method' => [
            'label' => 'Metodo',
            'placeholder' => 'GET, POST, PUT',
            'helper_text' => 'Metodo HTTP per form o azioni',
        ],
        'text' => [
            'label' => 'Testo',
            'placeholder' => 'Inserisci testo',
            'helper_text' => 'Contenuto testuale semplice',
        ],
        'subtitle' => [
            'label' => 'Sottotitolo',
            'placeholder' => 'Sottotitolo del contenuto',
            'helper_text' => 'Sottotitolo o descrizione aggiuntiva',
        ],
        'caption' => [
            'label' => 'Didascalia',
            'placeholder' => 'Didascalia per immagine o media',
            'helper_text' => 'Testo descrittivo per contenuti multimediali',
        ],
        'image' => [
            'label' => 'Immagine',
            'placeholder' => 'Seleziona immagine',
            'helper_text' => 'Immagine principale del contenuto',
        ],
        'video' => [
            'label' => 'Video',
            'placeholder' => 'URL o file video',
            'helper_text' => 'Video da incorporare o collegare',
        ],
        'gallery' => [
            'label' => 'Galleria',
            'placeholder' => 'Seleziona immagini per galleria',
            'helper_text' => 'Collezione di immagini per galleria',
        ],
        'logo' => [
            'label' => 'Logo',
            'help' => 'Carica il file del logo',
        ],
        'img_uuid' => [
            'label' => 'ID Immagine',
            'placeholder' => 'UUID immagine',
            'helper_text' => 'Identificatore univoco dell\'immagine',
        ],
        'src' => [
            'label' => 'Sorgente',
            'placeholder' => 'URL o percorso file',
            'helper_text' => 'Percorso o URL della risorsa',
        ],
        'alt' => [
            'label' => 'Testo alternativo',
            'placeholder' => 'Descrizione per screen reader',
            'helper_text' => 'Testo alternativo per accessibilità',
        ],
        'ratio' => [
            'label' => 'Proporzioni',
            'placeholder' => '16:9, 4:3, 1:1',
            'helper_text' => 'Rapporto di proporzione per immagini',
        ],
        'width' => [
            'label' => 'Larghezza',
            'placeholder' => 'Larghezza in px o %',
            'helper_text' => 'Larghezza dell\'elemento',
        ],
        'height' => [
            'label' => 'Altezza',
            'placeholder' => 'es. auto o 200px',
            'help' => 'Altezza in pixel o lasciare su auto',
        ],
        'company_name' => [
            'label' => 'Ragione Sociale',
            'placeholder' => 'Azienda S.p.A.',
            'help' => 'Nome completo dell\'azienda',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma 1, 00100 Roma RM',
            'help' => 'Indirizzo completo',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 06 1234567',
            'help' => 'Numero di telefono con prefisso internazionale',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'esempio@dominio.com',
            'help' => 'Indirizzo email valido',
        ],
        'items' => [
            'label' => 'Elementi',
            'help' => 'Elenco degli elementi da visualizzare',
        ],
        'links' => [
            'label' => 'Collegamenti',
            'placeholder' => 'Aggiungi collegamenti',
            'helper_text' => 'Lista di collegamenti o link',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'https://esempio.com',
            'help' => 'Inserisci un URL valido (inizia con http:// o https://)',
        ],
        'target' => [
            'label' => 'Destinazione',
            'help' => 'Dove aprire il collegamento',
            'options' => [
                '_self' => 'Stessa scheda',
                '_blank' => 'Nuova scheda',
            ],
        ],
        'button_text' => [
            'label' => 'Testo del pulsante',
            'placeholder' => 'Scopri di più',
            'help' => 'Testo visualizzato sul pulsante',
        ],
        'social_links' => [
            'label' => 'Social Media',
            'help' => 'Collegamenti ai profili social',
        ],
        'platform' => [
            'label' => 'Piattaforma',
            'help' => 'Seleziona la piattaforma social',
        ],
        'icon' => [
            'label' => 'Icona',
            'help' => 'Seleziona un\'icona da visualizzare',
        ],
        'content_blocks' => [
            'label' => 'Blocchi Contenuto',
            'help' => 'Sezioni di contenuto principale',
        ],
        'sidebar_blocks' => [
            'label' => 'Blocchi Sidebar',
            'help' => 'Contenuti della barra laterale',
        ],
        'footer_blocks' => [
            'label' => 'Blocchi Footer',
            'help' => 'Contenuti del piè di pagina',
        ],
    ],
    'actions' => [
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'create' => 'Crea',
        'add_item' => 'Aggiungi elemento',
        'remove_item' => 'Rimuovi elemento',
    ],
    'messages' => [
        'created' => 'Elemento creato con successo',
        'error' => 'Si è verificato un errore durante il salvataggio',
        'confirm_delete' => 'Sei sicuro di voler eliminare questo elemento?',
    ],
    'validation' => [
        'required' => 'Dieses Feld ist erforderlich',
        'email' => 'Inserisci un indirizzo email valido',
        'url' => 'Inserisci un URL valido (inizia con http:// o https://)',
    ],
];
