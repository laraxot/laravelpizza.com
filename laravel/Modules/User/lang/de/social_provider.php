<?php

declare(strict_types=1);

return [
    'resources' => 'Risorse',
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
    'navigation' => [
        'name' => 'Social Provider',
        'plural' => 'Social Providers',
        'group' => [
            'name' => 'Gestione Utenti',
            'description' => 'Gestione dei provider social',
        ],
        'label' => 'Social-Provider',
        'sort' => '93',
        'icon' => 'user-user-social',
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
    'plural' => [
        'model' => [
            'label' => 'social provider.plural.model',
        ],
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
