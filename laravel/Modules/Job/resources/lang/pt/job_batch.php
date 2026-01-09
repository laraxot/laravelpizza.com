<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lote de Trabalhos',
        'group' => 'Lotes',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Lote de Trabalhos',
    'plural_label' => 'Lotes de Trabalhos',
    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'name' => [
            'label' => 'Nome',
        ],
        'total_jobs' => [
            'label' => 'Trabalhos Totais',
        ],
        'pending_jobs' => [
            'label' => 'Trabalhos Pendentes',
        ],
        'failed_jobs' => [
            'label' => 'Trabalhos Falhados',
        ],
        'failed_job_ids' => [
            'label' => 'IDs de Trabalhos Falhados',
        ],
        'options' => [
            'label' => 'Opções',
        ],
        'created_at' => [
            'label' => 'Criado Em',
        ],
        'finished_at' => [
            'label' => 'Finalizado Em',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Ver Detalhes',
        ],
        'cancel' => [
            'label' => 'Cancelar',
        ],
        'prune_batches' => [
            'label' => 'Limpar Lotes',
        ],
    ],
];
