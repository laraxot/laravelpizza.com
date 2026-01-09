<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Importação',
        'group' => 'Importações',
        'icon' => 'heroicon-o-arrow-up-tray',
        'sort' => 26,
    ],
    'label' => 'Importação',
    'plural_label' => 'Importações',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'job_id' => [
            'label' => 'ID do Trabalho',
        ],
        'importable_type' => [
            'label' => 'Tipo Importável',
        ],
        'file_path' => [
            'label' => 'Caminho do Arquivo',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
        'completed_at' => [
            'label' => 'Completado Em',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importar',
        ],
        'upload' => [
            'label' => 'Carregar',
        ],
        'create' => [
            'label' => 'Criar',
        ],
    ],
];
