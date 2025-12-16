<?php

declare(strict_types=1);

return [
    'name' => 'Snapshots',
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'ID dello snapshot',
            'helper_text' => 'Identificativo univoco dello snapshot',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'placeholder' => 'UUID dell\'aggregato',
            'helper_text' => 'Identificativo univoco dell\'aggregato',
        ],
        'aggregate_version' => [
            'label' => 'Versione',
            'placeholder' => 'Versione dell\'aggregato',
            'helper_text' => 'Numero di versione dell\'aggregato',
        ],
        'state' => [
            'label' => 'Stato',
            'placeholder' => 'Stato dello snapshot',
            'helper_text' => 'Stato corrente dello snapshot',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'helper_text' => 'Data di creazione dello snapshot',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'helper_text' => 'Data dell\'ultima modifica',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Snapshot',
            'tooltip' => 'Crea un nuovo snapshot',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica lo snapshot',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina lo snapshot',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza i dettagli dello snapshot',
        ],
    ],
    'messages' => [
        'success' => [
            'created' => 'Snapshot creato con successo',
            'updated' => 'Snapshot aggiornato con successo',
            'deleted' => 'Snapshot eliminato con successo',
        ],
        'error' => [
            'create' => 'Errore durante la creazione dello snapshot',
            'update' => 'Errore durante l\'aggiornamento dello snapshot',
            'delete' => 'Errore durante l\'eliminazione dello snapshot',
        ],
        'confirm' => [
            'delete' => 'Sei sicuro di voler eliminare questo snapshot?',
        ],
    ],
    'filters' => [
        'aggregate_type' => [
            'label' => 'Tipo Aggregato',
            'options' => [
                'user' => 'Utente',
                'profile' => 'Profilo',
                'role' => 'Ruolo',
            ],
        ],
    ],
];
