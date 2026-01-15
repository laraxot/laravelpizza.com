<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Personal Access Client',
        'plural' => 'Personal Access Clients',
        'label' => 'Personal Access Client',
        'group' => '',
        'sort' => 6,
        'icon' => 'heroicon-o-key',
    ],
    'fields' => [
        'client_id' => [
            'label' => 'Client OAuth',
            'placeholder' => 'Seleziona un client OAuth',
            'help' => 'Il client OAuth associato a questo personal access client',
        ],
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco del personal access client',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data e ora di creazione del personal access client',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Personal Access Client',
            'success' => 'Personal Access Client creato con successo',
            'error' => 'Errore durante la creazione del Personal Access Client',
        ],
        'edit' => [
            'label' => 'Modifica Personal Access Client',
            'success' => 'Personal Access Client aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del Personal Access Client',
        ],
        'delete' => [
            'label' => 'Elimina Personal Access Client',
            'success' => 'Personal Access Client eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del Personal Access Client',
            'confirmation' => 'Sei sicuro di voler eliminare questo Personal Access Client?',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
        ],
    ],
    'label' => '',
    'plural_label' => '',
];
