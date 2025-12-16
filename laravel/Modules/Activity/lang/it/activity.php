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
        ],
        'description' => [
            'label' => 'Descrizione',
            'help' => 'Descrizione dell\'attività',
        ],
        'subject_type' => [
            'label' => 'Tipo Soggetto',
            'help' => 'Tipo di entità coinvolta',
        ],
        'subject_id' => [
            'label' => 'ID Soggetto',
            'help' => 'Identificativo dell\'entità coinvolta',
        ],
        'causer_type' => [
            'label' => 'Tipo Causatore',
            'help' => 'Tipo di entità che ha causato l\'attività',
        ],
        'causer_id' => [
            'label' => 'ID Causatore',
            'help' => 'Identificativo dell\'entità che ha causato l\'attività',
        ],
        'properties' => [
            'label' => 'Proprietà',
            'help' => 'Proprietà aggiuntive dell\'attività',
        ],
        'batch_uuid' => [
            'label' => 'Batch UUID',
            'help' => 'Identificativo del batch di attività',
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
];