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
<<<<<<< .merge_file_HHZgwB
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
=======
            'label' => 'Tipo Modello',
            'help' => 'Classe del modello a cui appartiene lo snapshot',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'model_id' => [
            'label' => 'ID Modello',
            'help' => 'Identificativo del record del modello',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'state' => [
            'label' => 'Stato',
            'help' => 'Stato corrente dello snapshot',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_by_type' => [
            'label' => 'Tipo Creatore',
            'help' => 'Classe dell\'entità che ha creato lo snapshot',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'created_by_id' => [
            'label' => 'ID Creatore',
            'help' => 'Identificativo dell\'entità che ha creato lo snapshot',
            'tooltip' => '',
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
>>>>>>> .merge_file_chfZO3
        ],
    ],
    'actions' => [
        'view' => [
<<<<<<< .merge_file_HHZgwB
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'logout' => [
            'tooltip' => 'logout',
=======
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
>>>>>>> .merge_file_chfZO3
        ],
    ],
];
