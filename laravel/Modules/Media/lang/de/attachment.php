<?php

declare(strict_types=1);

return [
    'pages' => 'Seiten',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Medien',
        'plural' => 'Medien',
        'group' => [
            'name' => '',
        ],
    ],
    'fields' => [
        'file' => 'Datei',
        'file_hint' => 'Einen Anhang hochladen',
        'name' => [
            'label' => 'Name',
        ],
        'guard_name' => 'Guard',
        'collection_name' => [
            'label' => 'Sammlung',
        ],
        'filename' => 'Dateiname',
        'mime_type' => 'Typ',
        'human_readable_size' => [
            'label' => 'Größe',
        ],
        'permissions' => 'Berechtigungen',
        'updated_at' => 'Aktualisiert am',
        'first_name' => 'Vorname',
        'last_name' => 'Nachname',
        'select_all' => [
            'name' => 'Alle auswählen',
            'message' => '',
        ],
        'creator' => [
            'name' => 'Ersteller',
            'full_name' => [
                'label' => 'Ersteller',
            ],
        ],
        'uploaded_at' => 'Aktualisiert am',
        'created_at' => [
            'label' => 'Hochgeladen am',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Wählen Sie eine XLS- oder CSV-Datei zum Hochladen aus',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Bereiche am',
            'columns' => [
                'name' => 'Bereichsname',
                'parent_name' => 'Übergeordneter Bereichsname',
            ],
        ],
    ],
];
