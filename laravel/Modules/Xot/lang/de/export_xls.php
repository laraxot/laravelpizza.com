<?php

declare(strict_types=1);

return [
    'actions' => [
        'export_xls' => [
            'label' => 'Excel exportieren',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Daten im Excel-Format (.xlsx) exportieren',
            'placeholder' => 'Nach Excel exportieren',
            'help' => 'Aktuelle Daten im Excel-Format für Offline-Analyse herunterladen',
            'description' => 'Aktion zum Exportieren von Daten im Excel-Format',
            'success' => 'Excel-Export erfolgreich abgeschlossen',
            'error' => 'Beim Excel-Export ist ein Fehler aufgetreten',
            'modal' => [
                'heading' => 'Nach Excel exportieren',
                'description' => 'Exportoptionen für die Excel-Datei auswählen',
                'confirm' => 'Exportieren',
                'cancel' => 'Abbrechen',
            ],
            'options' => [
                'include_headers' => 'Spaltenüberschriften einschließen',
                'format_dates' => 'Daten formatieren',
                'include_totals' => 'Summen einschließen',
            ],
        ],
    ],
];
