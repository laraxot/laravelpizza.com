<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Systemprotokoll',
        'plural' => 'Systemprotokolle',
        'label' => 'Systemprotokolle',
        'group' => [
            'name' => 'Zulage',
            'description' => 'Verwaltung der Verantwortungszulagen',
        ],
        'sort' => 43,
        'icon' => 'heroicon-o-clipboard-document-list',
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Eindeutige Protokollkennung',
        ],
        'id_tbl' => [
            'label' => 'Datensatz-ID',
            'help' => 'Kennung des verknüpften Datensatzes',
        ],
        'tbl' => [
            'label' => 'Tabelle',
            'help' => 'Tabellenname des verknüpften Datensatzes',
        ],
        'note' => [
            'label' => 'Notizen',
            'help' => 'Beschreibung der durchgeführten Aktion',
        ],
        'act' => [
            'label' => 'Aktion',
            'help' => 'Art der durchgeführten Aktion',
        ],
        'data' => [
            'label' => 'Daten',
            'help' => 'Serialisierte Betriebsdaten',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
            'help' => 'Datum und Uhrzeit der Protokollerstellung',
        ],
    ],

    'actions' => [
        'view' => [
            'label' => 'Ansehen',
        ],
    ],

    'messages' => [
        'empty_state' => 'Keine Protokolle gefunden',
        'readonly_warning' => 'Protokolle sind schreibgeschützt und können nicht geändert werden',
    ],
];
