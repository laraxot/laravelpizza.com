<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Nachrichten',
        'plural' => 'Nachrichten',
        'group' => [
            'name' => 'Kommunikation',
            'description' => 'Nachrichten- und Kommunikationsverwaltung',
        ],
        'label' => 'Nachrichten',
        'sort' => 60,
        'icon' => 'heroicon-o-envelope',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Nachrichtenkennung',
            'tooltip' => 'Nachrichten-ID',
            'helper_text' => '',
        ],
        'subject' => [
            'label' => 'Betreff',
            'placeholder' => 'Betreff eingeben',
            'help' => 'Nachrichtenbetreff',
            'tooltip' => 'Betreff',
            'helper_text' => '',
        ],
        'body' => [
            'label' => 'Inhalt',
            'placeholder' => 'Inhalt eingeben',
            'help' => 'Nachrichteninhalt',
            'tooltip' => 'Nachrichtentext',
            'helper_text' => '',
        ],
        'from' => [
            'label' => 'Von',
            'placeholder' => 'Absender eingeben',
            'help' => 'Nachrichtenabsender',
            'tooltip' => 'Von',
            'helper_text' => '',
        ],
        'to' => [
            'label' => 'An',
            'placeholder' => 'Empfänger eingeben',
            'help' => 'Nachrichtenempfänger',
            'tooltip' => 'An',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Status wählen',
            'help' => 'Nachrichtenstatus',
            'tooltip' => 'Status',
            'helper_text' => '',
            'options' => [
                'draft' => 'Entwurf',
                'sent' => 'Gesendet',
                'delivered' => 'Zugestellt',
                'read' => 'Gelesen',
                'failed' => 'Fehlgeschlagen',
            ],
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Neue Nachricht',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Neue Nachricht erstellen',
            'success' => 'Nachricht erfolgreich erstellt',
            'error' => 'Fehler beim Erstellen der Nachricht',
        ],
        'send' => [
            'label' => 'Senden',
            'icon' => 'heroicon-o-paper-airplane',
            'tooltip' => 'Nachricht senden',
            'success' => 'Nachricht erfolgreich gesendet',
            'error' => 'Fehler beim Senden',
        ],
    ],
    'model' => [
        'label' => 'Nachricht',
        'plural' => 'Nachrichten',
        'description' => 'Nachrichten- und Kommunikationsverwaltung',
    ],
];
