<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Criar',
        ],
    ],
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'queue' => [
            'label' => 'Fila',
        ],
        'progress' => [
            'label' => 'Progresso',
        ],
        'started_at' => [
            'label' => 'Iniciado Em',
        ],
    ],
    'navigation' => [
        'sort' => 87,
        'icon' => 'heroicon-o-cog-6-tooth',
        'group' => 'Sistema',
        'label' => 'Gerenciador de Trabalhos',
    ],
];
