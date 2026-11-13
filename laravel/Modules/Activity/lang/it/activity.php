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
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'log_name' => [
            'label' => 'Nome Log',
            'help' => 'Nome del log di attività',
            'tooltip' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'help' => 'Descrizione dell\'attività',
            'tooltip' => '',
        ],
        'subject_type' => [
            'label' => 'Tipo Soggetto',
            'help' => 'Tipo di entità coinvolta',
            'tooltip' => '',
        ],
        'subject_id' => [
            'label' => 'ID Soggetto',
            'help' => 'Identificativo dell\'entità coinvolta',
            'tooltip' => '',
        ],
        'causer_type' => [
            'label' => 'Tipo Causatore',
            'help' => 'Tipo di entità che ha causato l\'attività',
            'tooltip' => '',
        ],
        'causer_id' => [
            'label' => 'ID Causatore',
            'help' => 'Identificativo dell\'entità che ha causato l\'attività',
            'tooltip' => '',
        ],
        'properties' => [
            'label' => 'Proprietà',
            'help' => 'Proprietà aggiuntive dell\'attività',
            'tooltip' => '',
        ],
        'batch_uuid' => [
            'label' => 'Batch UUID',
            'help' => 'Identificativo del batch di attività',
            'tooltip' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data e ora di creazione dell\'attività',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'help' => 'Data e ora di aggiornamento dell\'attività',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
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
<<<<<<< .merge_file_hTkIug
        'logout' => [
            'tooltip' => 'logout',
=======
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'delete',
            'tooltip' => 'Elimina questa attività',
>>>>>>> .merge_file_2BtG5P
        ],
    ],
    'messages' => [
        'no_activities' => 'Nessuna attività trovata',
        'activity_restored' => 'Attività ripristinata con successo',
    ],
    'label' => 'Activity',
    'plural_label' => 'Activity (Plurale)',
];
