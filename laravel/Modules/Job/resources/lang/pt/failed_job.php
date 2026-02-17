<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Trabalho Falhado',
        'group' => 'Trabalhos Falhados',
        'icon' => 'heroicon-o-exclamation-triangle',
        'sort' => 27,
    ],
    'label' => 'Trabalho Falhado',
    'plural_label' => 'Trabalhos Falhados',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'connection' => [
            'label' => 'Conexão',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'queue' => [
            'label' => 'Fila',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'payload' => [
            'label' => 'Carga Útil',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'exception' => [
            'label' => 'Exceção',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_at' => [
            'label' => 'Falhado Em',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'retry' => [
            'label' => 'Tentar Novamente',
        ],
        'delete' => [
            'label' => 'Excluir',
        ],
        'retry_all' => [
            'label' => 'Tentar Todos Novamente',
        ],
        'delete_all' => [
            'label' => 'Excluir Todos',
        ],
    ],
];
