<?php

declare(strict_types=1);

return [
    'fields' => [
        'status' => [
            'label' => 'Status',
        ],
        'display_name' => [
            'label' => 'Nome de Exibição',
        ],
        'queue' => [
            'label' => 'Fila',
        ],
        'attempts' => [
            'label' => 'Tentativas',
        ],
        'reserved_at' => [
            'label' => 'Reservado Em',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
    ],
    'navigation' => [
        'sort' => 91,
        'icon' => 'heroicon-o-clock',
        'group' => 'Sistema',
        'label' => 'Trabalhos em Espera',
    ],
];
