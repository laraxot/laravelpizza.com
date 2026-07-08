<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Brief I',
        'group' => 'Zulage',
        'icon' => 'heroicon-o-document-check',
        'sort' => 64,
    ],

    'fields' => [
        'archivista_informatico' => [
            'label' => 'IT-Archivar',
            'help' => 'Zeigt an, ob der Mitarbeiter eine IT-Archivarzulage hat',
        ],
        'relazioni_pubblico' => [
            'label' => 'Öffentlichkeitsarbeit',
            'help' => 'Zeigt an, ob der Mitarbeiter eine Zulage für Öffentlichkeitsarbeit hat',
        ],
        'protezione_civile' => [
            'label' => 'Zivilschutz',
            'help' => 'Zeigt an, ob der Mitarbeiter eine Zivilschutzzulage hat',
        ],
        'formatore_professionale' => [
            'label' => 'Berufsausbilder',
            'help' => 'Zeigt an, ob der Mitarbeiter eine Berufsausbilderzulage hat',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Neuer Brief I',
            'success' => 'Brief I Zulage erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Zulage',
        ],
    ],

    'sections' => [
        'indennita' => [
            'label' => 'Sonderzulagen',
            'description' => 'Arten der anwendbaren Sonderzulagen',
        ],
    ],

    'messages' => [
        'empty_state' => 'Keine Brief I Zulagen gefunden',
    ],

    'indennita_types' => [
        'archivista_informatico' => 'IT-Archivar',
        'relazioni_pubblico' => 'Öffentlichkeitsarbeit',
        'protezione_civile' => 'Zivilschutz',
        'formatore_professionale' => 'Berufsausbilder',
    ],
];
