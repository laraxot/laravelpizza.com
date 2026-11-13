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
        'label' => 'Media',
        'sort' => 20,
        'icon' => 'media-main-animated',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'collection_name' => [
            'label' => 'Collezione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'filename' => [
            'label' => 'Nome File',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'mime_type' => [
            'label' => 'Tipo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'human_readable_size' => [
            'label' => 'Dimensione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'select_all' => [
            'name' => 'Seleziona Tutti',
            'message' => '',
            'label' => 'Seleziona tutto',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'creator' => [
            'name' => 'Creatore',
            'label' => 'Autore',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'uploaded_at' => [
            'label' => 'Caricato il',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'file_name' => [
            'label' => 'Nome del file',
        ],
        'disk' => [
            'label' => 'Disco',
        ],
        'size' => [
            'label' => 'Dimensione',
        ],
        'order_column' => [
            'label' => 'Ordine',
        ],
        'model_type' => [
            'label' => 'Tipo di oggetto',
        ],
        'model_id' => [
            'label' => 'Oggetto',
        ],
        'created_at' => [
            'label' => 'Creato il',
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
        'delete' => [
            'tooltip' => '',
            'icon' => 'delete',
        ],
    ],
    'model' => [
        'label' => 'media.model',
    ],
    'label' => 'Media',
    'plural_label' => 'Media (Plurale)',
];
