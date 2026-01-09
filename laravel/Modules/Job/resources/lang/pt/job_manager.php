<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Gerenciador de Trabalhos',
        'group' => 'Trabalhos',
        'icon' => 'heroicon-o-cog',
        'sort' => 43,
    ],
    'label' => 'Gerenciador de Trabalhos',
    'plural_label' => 'Gerenciadores de Trabalhos',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'queue' => [
            'label' => 'Fila',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'progress' => [
            'label' => 'Progresso',
        ],
        'started_at' => [
            'label' => 'Iniciado Em',
        ],
        'last_heartbeat' => [
            'label' => 'Último Batimento',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
        'updated_at' => [
            'label' => 'Atualizado Em',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Criar',
        ],
        'restart' => [
            'label' => 'Reiniciar',
        ],
        'pause' => [
            'label' => 'Pausar',
        ],
        'resume' => [
            'label' => 'Retomar',
        ],
    ],
];
