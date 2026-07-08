<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco dello snapshot',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'tooltip' => 'Identificativo univoco dell\'aggregato',
            'helper_text' => '',
            'description' => '',
        ],
        'aggregate_version' => [
            'label' => 'Versione Aggregato',
            'tooltip' => 'Numero di versione dell\'aggregato',
            'helper_text' => '',
            'description' => '',
        ],
        'state' => [
            'label' => 'Stato',
            'tooltip' => 'Stato corrente dello snapshot',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data e ora di creazione dello snapshot',
            'helper_text' => '',
            'description' => '',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza i dettagli dello snapshot',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina questo snapshot',
            'confirmation' => 'Sei sicuro di voler eliminare questo snapshot?',
        ],
    ],
    'filters' => [
        'date' => [
            'label' => 'Data',
            'tooltip' => 'Filtra per data di creazione',
        ],
        'state' => [
            'label' => 'Stato',
            'tooltip' => 'Filtra per stato',
        ],
    ],
    'label' => 'Snapshot Resource',
    'plural_label' => 'Snapshot Resource (Plurale)',
    'navigation' => [
        'name' => 'Snapshot Resource',
        'plural' => 'Snapshot Resource',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Snapshot Resource',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
];
