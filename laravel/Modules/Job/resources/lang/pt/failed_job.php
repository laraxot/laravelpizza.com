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
        ],
        'connection' => [
            'label' => 'Conexão',
        ],
        'queue' => [
            'label' => 'Fila',
        ],
        'payload' => [
            'label' => 'Carga Útil',
        ],
        'exception' => [
            'label' => 'Exceção',
        ],
        'failed_at' => [
            'label' => 'Falhado Em',
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
