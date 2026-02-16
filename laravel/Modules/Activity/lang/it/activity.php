<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Attività',
        'plural' => 'Attività',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione delle attività di sistema',
        ],
        'label' => 'Attività',
        'sort' => 60,
        'icon' => 'activity-animated',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo unico dell\'attività',
        ],
        'log_name' => [
            'label' => 'Nome Log',
            'help' => 'Nome del log di attività',
            'placeholder' => 'log_name',
            'helper_text' => 'log_name',
            'description' => 'log_name',
        ],
        'description' => [
            'label' => 'Descrizione',
            'help' => 'Descrizione dell\'attività',
            'placeholder' => 'description',
            'helper_text' => 'description',
            'description' => 'description',
        ],
        'subject_type' => [
            'label' => 'Tipo Soggetto',
            'help' => 'Tipo di entità coinvolta',
            'placeholder' => 'subject_type',
            'helper_text' => 'subject_type',
            'description' => 'subject_type',
        ],
        'subject_id' => [
            'label' => 'ID Soggetto',
            'help' => 'Identificativo dell\'entità coinvolta',
            'placeholder' => 'subject_id',
            'helper_text' => 'subject_id',
            'description' => 'subject_id',
        ],
        'causer_type' => [
            'label' => 'Tipo Causatore',
            'help' => 'Tipo di entità che ha causato l\'attività',
            'placeholder' => 'causer_type',
            'helper_text' => 'causer_type',
            'description' => 'causer_type',
        ],
        'causer_id' => [
            'label' => 'ID Causatore',
            'help' => 'Identificativo dell\'entità che ha causato l\'attività',
            'placeholder' => 'causer_id',
            'helper_text' => 'causer_id',
            'description' => 'causer_id',
        ],
        'properties' => [
            'label' => 'Proprietà',
            'help' => 'Proprietà aggiuntive dell\'attività',
            'placeholder' => 'properties',
            'helper_text' => 'properties',
            'description' => 'properties',
        ],
        'batch_uuid' => [
            'label' => 'Batch UUID',
            'help' => 'Identificativo del batch di attività',
            'placeholder' => 'batch_uuid',
            'helper_text' => 'batch_uuid',
            'description' => 'batch_uuid',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data e ora di creazione dell\'attività',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'help' => 'Data e ora di aggiornamento dell\'attività',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza dettagli attività',
        ],
        'restore' => [
            'label' => 'Ripristina',
            'tooltip' => 'Ripristina stato precedente',
        ],
    ],
    'messages' => [
        'no_activities' => 'Nessuna attività trovata',
        'activity_restored' => 'Attività ripristinata con successo',
    ],
    'label' => 'Activity',
    'plural_label' => 'Activity (Plurale)',
];
