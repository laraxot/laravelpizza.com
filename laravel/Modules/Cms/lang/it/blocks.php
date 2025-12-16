<?php

declare(strict_types=1);

return [
    'logo' => [
        'label' => 'Logo',
        'fields' => [
            'image' => 'Immagine',
            'alt' => 'Testo Alternativo',
            'text' => 'Testo Logo',
            'type' => 'Tipo Logo',
            'width' => 'Larghezza',
            'height' => 'Altezza',
            'url' => 'Link',
        ],
    ],
    'navigation' => [
        'label' => 'Navigazione',
        'fields' => [
            'items' => 'Voci Menu',
            'label' => 'Etichetta',
            'url' => 'URL',
            'type' => 'Tipo',
            'style' => 'Stile',
            'children' => 'Sottomenu',
            'alignment' => 'Allineamento',
            'orientation' => 'Orientamento',
        ],
    ],
    'actions' => [
        'label' => 'Azioni',
        'fields' => [
            'items' => 'Elementi',
            'label' => 'Etichetta',
            'url' => 'URL',
            'style' => 'Stile',
            'icon' => 'Icona',
            'size' => 'Dimensione',
            'alignment' => 'Allineamento',
            'gap' => 'Spaziatura',
        ],
    ],
    'social_links' => [
        'label' => 'Link Social',
        'fields' => [
            'title' => 'Titolo',
            'links' => 'Link Social',
            'platform' => 'Piattaforma',
            'url' => 'URL',
            'icon' => 'Icona',
        ],
    ],
    'quick_links' => [
        'label' => 'Link Rapidi',
        'fields' => [
            'title' => 'Titolo',
            'links' => 'Link',
            'label' => 'Etichetta',
            'url' => 'URL',
            'target' => 'Target',
        ],
    ],
    'newsletter' => [
        'label' => 'Newsletter',
        'fields' => [
            'title' => 'Titolo',
            'description' => 'Descrizione',
            'button_text' => 'Testo Pulsante',
            'placeholder' => 'Placeholder Email',
            'success_message' => 'Messaggio di Successo',
            'error_message' => 'Messaggio di Errore',
        ],
    ],
    'links' => [
        'label' => 'Menu Link',
        'fields' => [
            'title' => 'Titolo',
            'links' => 'Link',
            'label' => 'Etichetta',
            'url' => 'URL',
            'target' => 'Target',
            'icon' => 'Icona',
        ],
    ],
    'contact' => [
        'label' => 'Contatti',
        'fields' => [
            'title' => 'Titolo',
            'description' => 'Descrizione',
            'email' => 'Email',
            'phone' => 'Telefono',
            'address' => 'Indirizzo',
            'map_url' => 'URL Mappa',
        ],
    ],
    'info' => [
        'label' => 'Informazioni',
        'fields' => [
            'title' => 'Titolo',
            'description' => 'Descrizione',
            'logo' => 'Logo',
            'copyright' => 'Copyright',
        ],
    ],
    'hero' => [
        'label' => 'Hero',
        'fields' => [
            'title' => 'Titolo',
            'subtitle' => 'Sottotitolo',
            'image' => 'Immagine di sfondo',
            'cta_text' => 'Testo pulsante',
            'cta_link' => 'Link pulsante',
            'background_color' => 'Colore sfondo',
            'text_color' => 'Colore testo',
            'cta_color' => 'Colore pulsante',
        ],
    ],
    'rich_text' => [
        'label' => 'Testo Formattato',
        'fields' => [
            'content' => 'Contenuto',
            'style' => 'Stile',
        ],
    ],
    'features' => [
        'label' => 'Features',
        'fields' => [
            'title' => 'Titolo',
            'sections' => 'Sezioni',
            'section_title' => 'Titolo Sezione',
            'description' => 'Descrizione',
            'icon' => 'Icona',
        ],
    ],
    'stats' => [
        'label' => 'Statistiche',
        'fields' => [
            'title' => 'Titolo',
            'stats' => 'Statistiche',
            'number' => 'Numero',
            'label' => 'Etichetta',
        ],
    ],
];
