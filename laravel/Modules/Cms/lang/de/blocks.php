<?php

declare(strict_types=1);

return [
    'logo' => [
        'label' => 'Logo',
        'fields' => [
            'image' => 'Bild',
            'alt' => 'Alternativtext',
            'text' => 'Logo-Text',
            'type' => 'Logo-Typ',
            'width' => 'Breite',
            'height' => 'Höhe',
            'url' => 'Link',
        ],
    ],
    'navigation' => [
        'label' => 'Navigation',
        'fields' => [
            'items' => 'Menüpunkte',
            'label' => 'Bezeichnung',
            'url' => 'URL',
            'type' => 'Typ',
            'style' => 'Stil',
            'children' => 'Untermenü',
            'alignment' => 'Ausrichtung',
            'orientation' => 'Orientierung',
        ],
    ],
    'actions' => [
        'label' => 'Aktionen',
        'fields' => [
            'items' => 'Elemente',
            'label' => 'Bezeichnung',
            'url' => 'URL',
            'style' => 'Stil',
            'icon' => 'Symbol',
            'size' => 'Größe',
            'alignment' => 'Ausrichtung',
            'gap' => 'Abstand',
        ],
    ],
    'social_links' => [
        'label' => 'Social Links',
        'fields' => [
            'title' => 'Titel',
            'links' => 'Social Links',
            'platform' => 'Plattform',
            'url' => 'URL',
            'icon' => 'Symbol',
        ],
    ],
    'quick_links' => [
        'label' => 'Quick Links',
        'fields' => [
            'title' => 'Titel',
            'links' => 'Links',
            'label' => 'Bezeichnung',
            'url' => 'URL',
            'target' => 'Ziel',
        ],
    ],
    'newsletter' => [
        'label' => 'Newsletter',
        'fields' => [
            'title' => 'Titel',
            'description' => 'Beschreibung',
            'button_text' => 'Button-Text',
            'placeholder' => 'E-Mail-Platzhalter',
            'success_message' => 'Erfolgsnachricht',
            'error_message' => 'Fehlernachricht',
        ],
    ],
    'links' => [
        'label' => 'Menü-Links',
        'fields' => [
            'title' => 'Titel',
            'links' => 'Links',
            'label' => 'Bezeichnung',
            'url' => 'URL',
            'target' => 'Ziel',
            'icon' => 'Symbol',
        ],
    ],
    'contact' => [
        'label' => 'Kontakt',
        'fields' => [
            'title' => 'Titel',
            'description' => 'Beschreibung',
            'email' => 'E-Mail',
            'phone' => 'Telefon',
            'address' => 'Adresse',
            'map_url' => 'Karten-URL',
        ],
    ],
    'info' => [
        'label' => 'Informationen',
        'fields' => [
            'title' => 'Titel',
            'description' => 'Beschreibung',
            'logo' => 'Logo',
            'copyright' => 'Urheberrecht',
        ],
    ],
    'hero' => [
        'label' => 'Hero',
        'fields' => [
            'title' => 'Titel',
            'subtitle' => 'Untertitel',
            'image' => 'Hintergrundbild',
            'cta_text' => 'Button-Text',
            'cta_link' => 'Button-Link',
            'background_color' => 'Hintergrundfarbe',
            'text_color' => 'Textfarbe',
            'cta_color' => 'Button-Farbe',
        ],
    ],
    'rich_text' => [
        'label' => 'Rich Text',
        'fields' => [
            'content' => 'Inhalt',
            'style' => 'Stil',
        ],
    ],
    'features' => [
        'label' => 'Features',
        'fields' => [
            'title' => 'Titel',
            'sections' => 'Abschnitte',
            'section_title' => 'Abschnittstitel',
            'description' => 'Beschreibung',
            'icon' => 'Symbol',
        ],
    ],
    'stats' => [
        'label' => 'Statistiken',
        'fields' => [
            'title' => 'Titel',
            'stats' => 'Statistiken',
            'number' => 'Nummer',
            'label' => 'Bezeichnung',
        ],
    ],
];
