<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => [
            'label' => 'Criar',
        ],
        'logout' => [
            'tooltip' => 'Sair',
            'icon' => 'logout',
            'label' => 'Sair',
        ],
        'cancel' => [
            'tooltip' => 'Cancelar',
        ],
        'reorderRecords' => [
            'tooltip' => 'Reordenar registros',
        ],
    ],
    'fields' => [
        'edit' => [
            'label' => 'Editar',
        ],
        'payload' => [
            'label' => 'Carga útil',
        ],
        'id' => [
            'label' => 'ID',
        ],
        'queue' => [
            'label' => 'Fila',
        ],
        'attempts' => [
            'label' => 'Tentativas',
        ],
        'reserved_at' => [
            'label' => 'Reservado em',
        ],
        'available_at' => [
            'label' => 'Disponível em',
        ],
        'created_at' => [
            'label' => 'Criado em',
        ],
    ],
    'navigation' => [
        'sort' => 58,
        'icon' => 'heroicon-o-briefcase',
        'group' => 'Sistema',
        'label' => 'Trabalhos',
    ],
    'label' => 'Trabalhos',
];
