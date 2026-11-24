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
            'label' => 'Tipo Modello',
            'tooltip' => '',
        ],
        'model_id' => [
            'label' => 'ID Modello',
            'tooltip' => '',
        ],
        'state' => [
            'label' => 'Stato',
            'tooltip' => '',
        ],
        'created_by_type' => [
            'label' => 'Tipo Creatore',
            'tooltip' => '',
        ],
        'created_by_id' => [
            'label' => 'ID Creatore',
            'tooltip' => '',
        ],
    ],
    'label' => 'Snapshot',
    'plural_label' => 'Snapshot',
];
