<?php

declare(strict_types=1);

return [
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco dello snapshot',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'tooltip' => 'Identificativo univoco dell\'aggregato',
        ],
        'aggregate_version' => [
            'label' => 'Versione Aggregato',
            'tooltip' => 'Numero di versione dell\'aggregato',
        ],
        'state' => [
            'label' => 'Stato',
            'tooltip' => 'Stato corrente dello snapshot',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data e ora di creazione dello snapshot',
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
];
