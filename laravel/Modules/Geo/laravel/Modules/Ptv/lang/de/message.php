<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'message',
    ],
    'navigation' => [
        'name' => 'Nachricht',
        'plural' => 'Nachrichten',
        'group' => [
            'name' => 'Admin',
            'description' => 'Verwaltung und Konfiguration',
        ],
        'sort' => 80,
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'label' => 'Nachrichten',
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
        'id' => [
            'label' => 'ID',
        ],
        'parent_id' => [
            'label' => 'Übergeordnete ID',
            'placeholder' => 'parent_id',
            'helper_text' => 'parent_id',
            'description' => 'parent_id',
        ],
        'type' => [
            'label' => 'Nachrichtentyp',
            'placeholder' => 'Nachrichtentyp auswählen',
            'tooltip' => 'Nachrichtenkategorie',
            'helper_text' => 'Wählen Sie den Nachrichtentyp aus der vorhandenen Liste oder erstellen Sie einen neuen Typ mit der Schaltfläche +',
            'help' => 'Der Typ wird verwendet um Nachrichten im System zu kategorisieren und zu filtern',
            'description' => 'type',
        ],
        'title' => [
            'label' => 'Titel',
            'description' => 'title',
            'helper_text' => 'title',
            'placeholder' => 'title',
        ],
        'valutatore_id' => [
            'label' => 'Bewerter-ID',
        ],
        'stabi' => [
            'label' => 'Stabi',
        ],
        'repar' => [
            'label' => 'Repar',
        ],
        'anno' => [
            'label' => 'Jahr',
            'description' => 'anno',
            'helper_text' => 'anno',
            'placeholder' => 'anno',
        ],
        'matr' => [
            'label' => 'Matr',
        ],
        'txt' => [
            'description' => 'txt',
            'helper_text' => 'txt',
            'placeholder' => 'txt',
            'label' => 'txt',
        ],
        'new_type' => [
            'description' => 'new_type',
            'label' => 'new_type',
            'placeholder' => 'new_type',
            'helper_text' => 'new_type',
        ],
    ],
    'actions' => [
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
        'create_type' => [
            'label' => 'Neuen Typ erstellen',
            'tooltip' => 'Neuen Nachrichtentyp hinzufügen',
            'modal' => [
                'heading' => 'Neuen Nachrichtentyp erstellen',
                'description' => 'Geben Sie den Namen des neuen Nachrichtentyps ein. Er wird automatisch in Slug-Format konvertiert.',
                'confirm' => 'Typ erstellen',
                'cancel' => 'Abbrechen',
            ],
            'fields' => [
                'new_type' => [
                    'label' => 'Typname',
                    'placeholder' => 'z.B. Wichtige Benachrichtigung',
                    'tooltip' => 'Name des neuen Nachrichtentyps',
                    'helper_text' => 'Geben Sie den Typnamen ein. Er wird automatisch in Slug-Format konvertiert (z.B. "wichtige_benachrichtigung")',
                    'help' => 'Der Name wird für die Datenbankspeicherung in Slug-Format konvertiert',
                ],
            ],
            'messages' => [
                'success' => 'Neuer Typ erfolgreich erstellt',
                'error' => 'Fehler beim Erstellen des Typs',
            ],
        ],
        'logout' => [
            'tooltip' => 'abmelden',
        ],
    ],
    'widgets' => [
        'child_assets' => 'Untergeordnete Assets',
    ],
    'exceptions' => [
        'mandatory_data' => '{1} Pflichtangabe nicht vorhanden|{2} 2 Pflichtangaben nicht vorhanden|{3} 3 Pflichtangaben nicht vorhanden|[4,*] Mehrere Pflichtangaben nicht vorhanden',
    ],
];
