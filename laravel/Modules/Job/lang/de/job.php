<?php

declare(strict_types=1);

return [
    'pages' => 'Seiten',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Job',
        'plural' => 'Jobs',
        'group' => [
            'name' => 'Jobs',
            'description' => 'Hintergrundprozessverwaltung',
        ],
        'label' => 'jobs',
        'sort' => 30,
        'icon' => 'heroicon-o-cog',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Eindeutige Job-Kennung',
        ],
        'queue' => [
            'label' => 'Warteschlange',
            'tooltip' => 'Die Warteschlange, zu der dieser Job gehört',
        ],
        'payload' => [
            'label' => 'Payload',
            'tooltip' => 'Mit dem Job verknüpfte Daten',
        ],
        'attempts' => [
            'label' => 'Versuche',
            'tooltip' => 'Anzahl der Versuche, den Job auszuführen',
        ],
        'reserved_at' => [
            'label' => 'Reserviert am',
            'tooltip' => 'Datum und Uhrzeit, zu der der Job reserviert wurde',
        ],
        'available_at' => [
            'label' => 'Verfügbar am',
            'tooltip' => 'Datum und Uhrzeit, zu der der Job verfügbar wurde',
        ],
        'created_at' => [
            'label' => 'Erstellt am',
            'tooltip' => 'Job-Erstellungsdatum',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Aktueller Job-Status',
        ],
        'progress' => [
            'label' => 'Fortschritt',
            'tooltip' => 'Job-Abschlussprozentsatz',
        ],
        'type' => [
            'label' => 'Typ',
            'tooltip' => 'Job-Typ (z.B. Import, Export)',
        ],
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Job-Name',
        ],
        'description' => [
            'label' => 'Beschreibung',
            'tooltip' => 'Job-Beschreibung',
            'placeholder' => 'Geben Sie eine Beschreibung ein',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Job-Wächter',
        ],
        'permissions' => [
            'label' => 'Berechtigungen',
            'tooltip' => 'Mit dem Job verknüpfte Berechtigungen',
        ],
        'updated_at' => [
            'label' => 'Aktualisiert am',
            'tooltip' => 'Datum der letzten Job-Aktualisierung',
        ],
        'first_name' => [
            'label' => 'Vorname',
            'tooltip' => 'Vorname der verantwortlichen Person',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'tooltip' => 'Nachname der verantwortlichen Person',
        ],
        'select_all' => [
            'label' => 'Alle auswählen',
            'tooltip' => 'Alle verfügbaren Elemente auswählen',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'value' => [
            'label' => 'value',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importieren',
            'tooltip' => 'Daten aus einer Datei importieren',
            'icon' => 'import-icon',
            'color' => 'blue',
            'fields' => [
                'import_file' => [
                    'label' => 'Wählen Sie eine XLS- oder CSV-Datei zum Hochladen aus',
                    'placeholder' => 'Wählen Sie die zu hochladende Datei aus',
                ],
            ],
        ],
        'export' => [
            'label' => 'Exportieren',
            'tooltip' => 'Daten in eine Datei exportieren',
            'icon' => 'export-icon',
            'color' => 'green',
            'filename_prefix' => 'Bereiche zum',
            'columns' => [
                'name' => [
                    'label' => 'Bereichsname',
                    'tooltip' => 'Name des zu exportierenden Bereichs',
                ],
                'parent_name' => [
                    'label' => 'Übergeordneter Bereichsname',
                    'tooltip' => 'Name des übergeordneten Bereichs',
                ],
            ],
        ],
        'run' => [
            'label' => 'Ausführen',
            'icon' => 'play',
            'color' => 'green',
            'modal' => [
                'heading' => 'Job ausführen',
                'description' => 'Möchten Sie diesen Job ausführen?',
            ],
            'messages' => [
                'success' => 'Job erfolgreich gestartet',
            ],
        ],
        'stop' => [
            'label' => 'Stoppen',
            'icon' => 'pause',
            'color' => 'red',
            'modal' => [
                'heading' => 'Job stoppen',
                'description' => 'Möchten Sie diesen Job stoppen?',
            ],
            'messages' => [
                'success' => 'Job erfolgreich gestoppt',
            ],
        ],
        'delete' => [
            'label' => 'Löschen',
            'icon' => 'trash',
            'color' => 'red',
            'modal' => [
                'heading' => 'Job löschen',
                'description' => 'Sind Sie sicher, dass Sie diesen Job löschen möchten?',
            ],
            'messages' => [
                'success' => 'Job erfolgreich gelöscht',
            ],
        ],
    ],
    'messages' => [
        'no_jobs' => 'Keine Jobs vorhanden',
        'job_started' => 'Job gestartet',
        'job_stopped' => 'Job gestoppt',
        'job_completed' => 'Job abgeschlossen',
        'job_failed' => 'Job fehlgeschlagen',
    ],
    'statuses' => [
        'pending' => 'Ausstehend',
        'processing' => 'In Bearbeitung',
        'completed' => 'Abgeschlossen',
        'failed' => 'Fehlgeschlagen',
        'stopped' => 'Gestoppt',
    ],
    'types' => [
        'import' => 'Import',
        'export' => 'Export',
        'process' => 'Verarbeitung',
        'notification' => 'Benachrichtigung',
        'cleanup' => 'Bereinigung',
    ],
];
