<?php

declare(strict_types=1);

return [
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Media',
        'plural' => 'Media',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Gestione dei file multimediali',
        ],
        'label' => 'media',
        'sort' => 20,
        'icon' => 'media-main-animated',
    ],
    'fields' => [
        'name' => 'Nome',
        'guard_name' => 'Guard',
        'collection_name' => 'Collezione',
        'filename' => 'Nome File',
        'mime_type' => 'Tipo',
        'human_readable_size' => 'Dimensione',
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
        ],
        'uploaded_at' => 'Caricato il',
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
    'model' => [
        'label' => 'media.model',
    ],
];
