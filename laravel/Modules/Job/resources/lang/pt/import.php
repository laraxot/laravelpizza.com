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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'job_id' => [
            'label' => 'ID do Trabalho',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'importable_type' => [
            'label' => 'Tipo Importável',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'file_path' => [
            'label' => 'Caminho do Arquivo',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Criado Em',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'completed_at' => [
            'label' => 'Completado Em',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
