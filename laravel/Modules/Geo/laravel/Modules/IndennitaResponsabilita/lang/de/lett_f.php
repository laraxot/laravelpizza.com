<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Brief F',
        'group' => 'Zulage',
        'icon' => 'heroicon-o-document-text',
        'sort' => 86,
    ],

    'fields' => [
        'matr' => [
            'label' => 'Personalnummer',
            'placeholder' => 'Mitarbeiternummer',
            'help' => 'Mitarbeiter-Personalnummer',
        ],
        'posizione_lavoro' => [
            'label' => 'Arbeitsposition',
            'placeholder' => 'Beschreiben Sie die Arbeitsposition',
            'help' => 'Detaillierte Beschreibung der Position und Verantwortlichkeiten',
        ],
        'complessita' => [
            'label' => 'Komplexität',
            'placeholder' => '0-40',
            'help' => 'Bewertung der Rollenkomplexität (0-40 Punkte)',
        ],
        'coordinamento' => [
            'label' => 'Koordination',
            'placeholder' => '0-30',
            'help' => 'Bewertung der Koordinationsaktivitäten (0-30 Punkte)',
        ],
        'responsabilita' => [
            'label' => 'Verantwortung',
            'placeholder' => '0-30',
            'help' => 'Bewertung des Verantwortungsniveaus (0-30 Punkte)',
        ],
        'tot' => [
            'label' => 'Gesamt',
            'help' => 'Gesamtpunktzahl (automatisch berechnet)',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Neuer Brief F',
            'success' => 'Brief F Bewertung erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Bewertung',
        ],
    ],

    'sections' => [
        'valutazione' => [
            'label' => 'Bewertungskriterien',
            'description' => 'Punkte für Komplexität, Koordination und Verantwortung',
        ],
    ],

    'messages' => [
        'empty_state' => 'Keine Brief F Bewertungen gefunden',
        'auto_calculated' => 'Werte automatisch basierend auf Punkten berechnet',
    ],
];
