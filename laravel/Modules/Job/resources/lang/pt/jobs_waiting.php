<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Trabalhos em Espera',
        'group' => 'Trabalhos',
        'icon' => 'heroicon-o-clock',
        'sort' => 30,
    ],
    'label' => 'Trabalho em Espera',
    'plural_label' => 'Trabalhos em Espera',
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
        'attempts' => [
            'label' => 'Tentativas',
        ],
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Nome de Exibição',
        ],
        'reserved_at' => [
            'label' => 'Reservado Em',
        ],
        'available_at' => [
            'label' => 'Disponível Em',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
    ],
    'actions' => [
        'process' => [
            'label' => 'Processar',
        ],
        'retry' => [
            'label' => 'Tentar Novamente',
        ],
    ],
];
