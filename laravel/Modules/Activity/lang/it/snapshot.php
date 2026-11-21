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
<<<<<<< .merge_file_aUTwQh
            'helper_text' => '',
            'description' => '',
        ],
        'id' => [
            'label' => 'ID',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_version' => [
            'label' => 'Versione Aggregato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_type' => [
            'label' => 'Tipo Aggregato',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'view',
            'tooltip' => 'Visualizza i dettagli dello snapshot',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'edit',
            'tooltip' => 'Modifica questo snapshot',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'delete',
            'tooltip' => 'Elimina questo snapshot',
=======
>>>>>>> .merge_file_zBIv4s
        ],
    ],
    'label' => 'Snapshot',
    'plural_label' => 'Snapshot',
];
