<?php

declare(strict_types=1);

return [
    'fill_out_the_form' => 'ausfüllen',
    'resource' => [
        'name' => 'Aktion',
    ],
    'navigation' => [
        'name' => 'Aktion',
        'plural' => 'Aktionen',
        'group' => [
            'name' => 'Admin',
        ],
    ],
    'fields' => [
        'brand' => 'Marke',
        'model' => 'Modell',
        'description' => 'Beschreibung',
        'serial_number' => 'Seriennummer',
        'inventory_number' => 'Inventarnummer',
        'code' => 'Identifikator',
        'manufacturing_year' => 'Herstellungsjahr',
        'purchase_year' => 'Kaufjahr',
        'is_enabled' => 'Ist aktiv?',
        'asset_type' => 'Typ',
        'area' => 'Bereich',
        'parent' => 'Übergeordnetes Asset',
        'name' => 'Name',
    ],
    'actions' => [
        'compila' => [
            'label' => 'Ausfüllen',
        ],
        'copy_from_last_year' => 'Aus dem Vorjahr kopieren',
        'merge_double_row_cateco_yea' => 'Doppelte Zeilen zusammenführen',
        'populate_year' => 'Jahr auffüllen',
        'trova_esclusi' => [
            'label' => 'Ausgeschlossene finden',
        ],
        'fill_out_the_form' => 'ausfüllen',
        'showing_records' => 'Zeige :count Datensätze von :total',
        'showing_limited_results' => 'Eingeschränkte Ergebnisse. Verwenden Sie Filter zur Verfeinerung.',
        'enable' => [
            'cta' => 'Aktivieren',
        ],
        'disable' => [
            'cta' => 'Deaktivieren',
        ],
        'import' => [
            'row_number' => 'Zeile :row',
            'fields' => [
                'import_file' => 'Wählen Sie eine XLS- oder CSV-Datei zum Hochladen',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Asset-Liste vom',
            'columns' => [
                'brand' => 'Marke',
                'model' => 'Modell',
                'description' => 'Beschreibung',
                'serial_number' => 'Seriennummer',
                'inventory_number' => 'Inventarnummer',
                'code' => 'Identifikator',
                'manufacturing_year' => 'Herstellungsjahr',
                'purchase_year' => 'Kaufjahr',
                'is_enabled' => 'Ist aktiv?',
                'asset_type' => 'Typ',
                'parent_inventory_number' => 'Übergeordnete Inventarnummer',
            ],
        ],
        'delete_cessati' => [
            'label' => 'Cessati löschen',
            'selection_title' => 'Jahresauswahl',
            'selection_description' => 'Wählen Sie das Jahr um Datensätze zu finden die in Indennità Responsabilità aber nicht in Rep00f existieren',
            'year_label' => 'Jahr',
            'year_placeholder' => 'Jahr auswählen',
            'records_title' => 'Zu löschende Datensätze',
            'records_description' => 'Diese Datensätze werden dauerhaft gelöscht',
            'count_label' => 'Gefundene Datensätze',
            'preview_label' => 'Datensatzvorschau',
            'select_year' => 'Jahr auswählen',
            'records_found' => ':count Datensätze gefunden',
            'no_records_found' => 'Keine Datensätze gefunden',
            'more_records' => 'und :count weitere Datensätze...',
            'modal_title' => 'Cessati-Datensätze löschen',
            'modal_heading' => 'Cessati-Datensätze löschen',
            'modal_description' => 'Löschen Sie die Datensätze die in Indennità Responsabilità aber nicht in Rep00f für das ausgewählte Jahr existieren',
            'confirm_delete' => 'Datensätze löschen',
            'cancel' => 'Abbrechen',
            'no_year_error' => 'Bitte wählen Sie ein Jahr',
            'success_title' => 'Datensätze erfolgreich gelöscht',
            'success_message' => ':count Datensätze wurden gelöscht',
            'no_records_title' => 'Keine Datensätze zu löschen',
            'no_records_message' => 'Keine Datensätze für das ausgewählte Jahr gefunden',
            'error_title' => 'Löschfehler',
            'error_message' => 'Ein Fehler ist aufgetreten: :error',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Untergeordnete Assets',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Pflichtangabe nicht vorhanden|{2} 2 Pflichtangaben nicht vorhanden|{3} 3 Pflichtangaben nicht vorhanden|[4,*] Mehrere Pflichtangaben nicht vorhanden',
    ],
];
