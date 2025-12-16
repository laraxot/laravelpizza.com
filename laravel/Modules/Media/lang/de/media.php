<?php

declare(strict_types=1);

return [
    'pages' => 'Seiten',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Medien',
        'plural' => 'Medien',
        'group' => [
            'name' => 'System',
            'description' => 'Multimedia-Dateiverwaltung',
        ],
        'label' => 'media',
        'sort' => '20',
        'icon' => 'media-main-animated',
    ],
    'fields' => [
        'name' => 'Name',
        'guard_name' => 'Guard',
        'collection_name' => 'Sammlung',
        'filename' => 'Dateiname',
        'mime_type' => 'Typ',
        'human_readable_size' => 'Größe',
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
        ],
        'uploaded_at' => 'Hochgeladen am',
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
