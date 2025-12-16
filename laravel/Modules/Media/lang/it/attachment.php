<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Media',
        'plural' => 'Media',
        'group' => [
            'name' => '',
        ],
    ],
    'fields' => [
        'file' => 'file',
        'file_hint' => 'Carica un allegato',
        'name' => [
            'label' => 'Nome',
        ],
        'guard_name' => 'Guard',
        'collection_name' => [
            'label' => 'Collezione',
        ],
        'filename' => 'Nome File',
        'mime_type' => 'Tipo',
        'human_readable_size' => [
            'label' => 'Dimensione',
        ],
        'permissions' => 'Permessi',
        'updated_at' => 'Aggiornato il',
        'first_name' => 'Nome',
        'last_name' => 'Cognome',
        'select_all' => [
            'name' => 'Seleziona Tutti',
            'message' => '',
        ],
        'creator' => [
            'name' => 'Creatore',
            'full_name' => [
                'label' => 'Creatore',
            ],
        ],
        'uploaded_at' => 'Aggiornato il',
        'created_at' => [
            'label' => 'Caricato il',
        ],
    ],
    'actions' => [
        'import' => [
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
];
