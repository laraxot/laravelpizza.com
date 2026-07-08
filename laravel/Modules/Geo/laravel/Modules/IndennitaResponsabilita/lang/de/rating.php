<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Bewertungen',
        'plural' => 'Bewertungen',
        'group' => [
            'name' => 'Evaluierungen',
            'description' => 'Personalbewertungssystem',
        ],
        'label' => 'Bewertungen',
        'sort' => 50,
        'icon' => 'heroicon-o-star',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Bewertungskennung',
            'tooltip' => 'Bewertungs-ID',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Titel',
            'placeholder' => 'Titel eingeben',
            'help' => 'Bewertungstitel',
            'tooltip' => 'Titel',
            'helper_text' => '',
        ],
        'body' => [
            'label' => 'Beschreibung',
            'placeholder' => 'Beschreibung eingeben',
            'help' => 'Detaillierte Bewertungsbeschreibung',
            'tooltip' => 'Textinhalt',
            'helper_text' => '',
        ],
        'rating' => [
            'label' => 'Punktzahl',
            'placeholder' => 'Punktzahl eingeben',
            'help' => 'Vergebene Punktzahl (1-5)',
            'tooltip' => 'Numerische Bewertung',
            'helper_text' => '',
        ],
        'author' => [
            'label' => 'Autor',
            'placeholder' => 'Autor wählen',
            'help' => 'Wer die Bewertung durchgeführt hat',
            'tooltip' => 'Bewerter',
            'helper_text' => '',
        ],
        'approved' => [
            'label' => 'Genehmigt',
            'help' => 'Zeigt an, ob die Bewertung genehmigt wurde',
            'tooltip' => 'Genehmigungsstatus',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Bewertung erstellen',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Neue Bewertung erstellen',
            'success' => 'Bewertung erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Bewertung',
        ],
        'approve' => [
            'label' => 'Genehmigen',
            'icon' => 'heroicon-o-check-badge',
            'tooltip' => 'Bewertung genehmigen',
            'success' => 'Bewertung erfolgreich genehmigt',
            'error' => 'Fehler beim Genehmigen',
        ],
    ],
    'model' => [
        'label' => 'Bewertung',
        'plural' => 'Bewertungen',
        'description' => 'Personalbewertungs- und Ratingsystem',
    ],
];
