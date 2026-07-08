<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Rating Morph',
    ],
    'navigation' => [
        'name' => 'Rating Morph',
        'plural' => 'Rating Morph',
        'group' => [
            'name' => 'Admin',
            'description' => 'Administrative Verwaltung',
        ],
        'label' => 'Rating Morph',
        'sort' => 92,
        'icon' => 'heroicon-o-chart-bar',
    ],
    'fields' => [
        'brand' => 'Marke',
        'model' => 'Modell',
        'description' => 'Beschreibung',
        'serial_number' => 'Seriennummer',
        'inventory_number' => 'Inventarcode',
        'code' => 'Kennung',
        'manufacturing_year' => 'Herstellungsjahr',
        'purchase_year' => 'Kaufjahr',
        'is_enabled' => 'Ist aktiv?',
        'asset_type' => 'Asset-Typ',
        'area' => 'Bereich',
        'parent' => 'Übergeordnetes Asset',
        'name' => 'Name',
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
                'inventory_number' => 'Inventarcode',
                'code' => 'Kennung',
                'manufacturing_year' => 'Herstellungsjahr',
                'purchase_year' => 'Kaufjahr',
                'is_enabled' => 'Ist aktiv?',
                'asset_type' => 'Asset-Typ',
                'parent_inventory_number' => 'Übergeordneter Inventarcode',
            ],
        ],
    ],
    'widgets' => [
        'child_assets' => 'Untergeordnete Assets',
    ],
    'exceptions' => [
        'not_found' => 'Rating morph nicht gefunden',
        'unauthorized' => 'Sie sind nicht berechtigt, diese Aktion auszuführen',
    ],
];
