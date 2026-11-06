<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-document-text',
        'group' => 'Überwachung',
        'label' => 'Log',
    ],
    'title' => 'Systemlog',
    'tree' => [
        'heading' => 'Ordner und Dateien',
    ],
    'fields' => [
        'file' => 'Datei',
        'level' => 'Level',
        'search' => 'Im Text suchen',
        'window' => 'Zu lesender Teil',
    ],
    'placeholders' => [
        'search' => 'In den angezeigten Einträgen suchen...',
        'all_levels' => 'Alle Level',
    ],
    'window_option' => 'Letzte :size',
    'actions' => [
        'refresh' => [
            'label' => 'Aktualisieren',
        ],
        'download' => [
            'label' => 'Datei herunterladen',
        ],
    ],
    'messages' => [
        'no_files' => 'Keine Logdateien in storage/logs gefunden.',
        'no_file_selected' => 'Wählen Sie eine Logdatei zum Ansehen aus.',
        'file_unavailable' => 'Die Logdatei ist nicht verfügbar: Sie wurde möglicherweise rotiert oder entfernt. Aktualisieren Sie die Liste.',
        'no_entries' => 'Keine Einträge entsprechen den Filtern im gelesenen Teil der Datei.',
        'summary' => ':shown von :total passenden Einträgen angezeigt (neueste zuerst).',
        'file_info' => ':size, zuletzt geändert am :date',
        'partial_read' => 'Nur die letzten :read von :size wurden gelesen. Suche und Filter gelten für diesen Teil: Verwenden Sie „Datei herunterladen“, um die vollständige Datei zu erhalten, oder erweitern Sie „Zu lesender Teil“.',
        'entry_omitted' => '... :count Zeichen in der Mitte ausgelassen: Verwenden Sie „Datei herunterladen“ für den vollständigen Text ...',
        'sensitive' => 'Achtung: Logs können personenbezogene Daten (E-Mails, Telefonnummern) und andere vertrauliche Informationen enthalten.',
    ],
];
