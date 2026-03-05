<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Snapshot',
        'plural' => 'Snapshots',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione degli snapshot di sistema',
        ],
        'label' => 'Snapshot',
        'sort' => 63,
        'icon' => 'activity-snapshot-animated',
    ],
    'fields' => [
        'model_type' => [
            'label' => 'model_type',
            'placeholder' => 'model_type',
            'helper_text' => 'model_type',
            'description' => 'model_type',
            'tooltip' => '',
        ],
        'model_id' => [
            'label' => 'model_id',
            'placeholder' => 'model_id',
            'helper_text' => 'model_id',
            'description' => 'model_id',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'state',
            'placeholder' => 'state',
            'helper_text' => 'state',
            'description' => 'state',
            'tooltip' => '',
        ],
        'created_by_type' => [
            'label' => 'created_by_type',
            'placeholder' => 'created_by_type',
            'helper_text' => 'created_by_type',
            'description' => 'created_by_type',
            'tooltip' => '',
        ],
        'created_by_id' => [
            'label' => 'created_by_id',
            'placeholder' => 'created_by_id',
            'helper_text' => 'created_by_id',
            'description' => 'created_by_id',
            'tooltip' => '',
        ],
        'id' => [
            'label' => 'id',
        ],
        'aggregate_uuid' => [
            'label' => 'aggregate_uuid',
        ],
        'aggregate_version' => [
            'label' => 'aggregate_version',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'aggregate_type' => [
            'label' => 'aggregate_type',
        ],
    ],
    'label' => 'Snapshot',
    'plural_label' => 'Snapshot (Plurale)',
    'actions' => [
        'create' => [
            'label' => 'Crea Snapshot',
        ],
        'edit' => [
            'label' => 'Modifica Snapshot',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'Elimina Snapshot',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
    ],
];
