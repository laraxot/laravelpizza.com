<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'send_email_parameters',
    ],
    'navigation' => [
        'name' => 'send_email_parameters',
        'plural' => 'send_email_parameters',
        'group' => [
            'name' => 'Invia',
        ],
    ],
    'fields' => [
        'name' => 'Nome Area',
        'parent' => 'Settore di appartenenza',
        'parent.name' => 'Settore di appartenenza',
        'parent_name' => 'Settore di appartenenza',
        'assets' => 'Quantità di asset',
    ],
    'actions' => [
        'import' => [
            'name' => 'Importa da file',
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'name' => 'Esporta dati',
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
];
