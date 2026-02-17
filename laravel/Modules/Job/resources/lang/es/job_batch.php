<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Lote de Trabajos',
        'group' => 'Lotes',
        'icon' => 'heroicon-o-queue-list',
        'sort' => 29,
    ],
    'label' => 'Lote de Trabajos',
    'plural_label' => 'Lotes de Trabajos',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'name' => [
            'label' => 'Nombre',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'total_jobs' => [
            'label' => 'Trabajos Totales',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'pending_jobs' => [
            'label' => 'Trabajos Pendientes',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_jobs' => [
            'label' => 'Trabajos Fallidos',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'failed_job_ids' => [
            'label' => 'IDs de Trabajos Fallidos',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'options' => [
            'label' => 'Opciones',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Creado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'finished_at' => [
            'label' => 'Finalizado En',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view_details' => [
            'label' => 'Ver Detalles',
        ],
        'cancel' => [
            'label' => 'Cancelar',
        ],
        'prune_batches' => [
            'label' => 'Limpiar Lotes',
        ],
    ],
];
