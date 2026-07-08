<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco dell\'attività999',
            'helper_text' => '',
            'description' => '',
        ],
        'description' => [
            'label' => 'Descrizione',
            'tooltip' => 'Descrizione dell\'attività',
            'helper_text' => '',
            'description' => '',
        ],
        'subject_type' => [
            'label' => 'Tipo Soggetto',
            'tooltip' => 'Tipo di entità soggetta all\'attività',
            'helper_text' => '',
            'description' => '',
        ],
        'subject_id' => [
            'label' => 'ID Soggetto',
            'tooltip' => 'Identificativo dell\'entità soggetta all\'attività',
            'helper_text' => '',
            'description' => '',
        ],
        'causer_type' => [
            'label' => 'Tipo Autore',
            'tooltip' => 'Tipo di entità che ha causato l\'attività',
            'helper_text' => '',
            'description' => '',
        ],
        'causer_id' => [
            'label' => 'ID Autore',
            'tooltip' => 'Identificativo dell\'entità che ha causato l\'attività',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data e ora di creazione dell\'attività',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza i dettagli dell\'attività',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina questa attività',
            'confirmation' => 'Sei sicuro di voler eliminare questa attività?',
        ],
    ],
    'filters' => [
        'date' => [
            'label' => 'Data',
            'tooltip' => 'Filtra per data di creazione',
        ],
        'type' => [
            'label' => 'Tipo',
            'tooltip' => 'Filtra per tipo di attività',
        ],
    ],
    'snapshots' => [
        'fields' => [
            'id' => [
                'label' => 'ID',
                'help' => 'Identificativo univoco dello snapshot',
            ],
            'aggregate_uuid' => [
                'label' => 'UUID Aggregato',
                'help' => 'UUID dell\'aggregato',
            ],
            'aggregate_version' => [
                'label' => 'Versione Aggregato',
                'help' => 'Versione dell\'aggregato',
            ],
            'state' => [
                'label' => 'Stato',
                'help' => 'Stato dello snapshot',
            ],
            'created_at' => [
                'label' => 'Data Creazione',
                'help' => 'Data di creazione dello snapshot',
            ],
            'updated_at' => [
                'label' => 'Data Aggiornamento',
                'help' => 'Data di ultimo aggiornamento dello snapshot',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Missing Navigation Label',
        'plural_label' => 'Missing Navigation Plural Label',
        'group' => 'Missing Group',
        'icon' => 'heroicon-o-puzzle-piece',
        'sort' => 100,
    ],
    'label' => 'Missing Label',
    'plural_label' => 'Missing Plural label',
];
