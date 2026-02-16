<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Personal Access Client',
        'plural_label' => 'Personal Access Client',
        'group' => 'OAuth',
        'icon' => 'heroicon-o-key',
        'sort' => 6,
    ],
    'label' => 'Personal Access Client',
    'plural_label' => 'Personal Access Client',
    'fields' => [
        'client_id' => [
            'label' => 'Client OAuth',
            'tooltip' => 'Client OAuth associato',
            'placeholder' => 'Seleziona un client OAuth',
            'helper_text' => 'Il client OAuth associato a questo personal access client',
            'description' => 'Client OAuth per personal access',
        ],
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco',
            'helper_text' => 'Identificativo univoco del personal access client',
            'description' => 'ID del personal access client',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione',
            'helper_text' => 'Data e ora di creazione del personal access client',
            'description' => 'Timestamp di creazione',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'tooltip' => 'Data di ultimo aggiornamento',
            'helper_text' => 'Data e ora dell\'ultimo aggiornamento',
            'description' => 'Timestamp di aggiornamento',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Personal Access Client',
            'tooltip' => 'Crea un nuovo personal access client',
            'helper_text' => 'Crea un nuovo personal access client',
            'description' => 'Azione per creare',,
            'success' => 'Personal Access Client creato con successo',
            'error' => 'Errore durante la creazione del Personal Access Client',
        ],
        'edit' => [
            'label' => 'Modifica Personal Access Client',
            'tooltip' => 'Modifica il personal access client',
            'helper_text' => 'Modifica il personal access client',
            'description' => 'Azione per modificare',
            'success' => 'Personal Access Client aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del Personal Access Client',
        ],
        'delete' => [
            'label' => 'Elimina Personal Access Client',
            'tooltip' => 'Elimina il personal access client',
            'helper_text' => 'Elimina il personal access client',
            'description' => 'Azione per eliminare',
            'success' => 'Personal Access Client eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del Personal Access Client',
            'confirmation' => 'Sei sicuro di voler eliminare questo Personal Access Client?',
        ],
        'logout' => [
            'label' => 'Logout',
            'tooltip' => 'Disconnettiti',
            'helper_text' => 'Esci dall\'account',
            'description' => 'Azione di logout',
            'icon' => 'heroicon-o-arrow-right-on-rectangle',
        ],
    ],
    'messages' => [
        'created' => 'Personal Access Client creato con successo',
        'updated' => 'Personal Access Client aggiornato con successo',
        'deleted' => 'Personal Access Client eliminato con successo',
    ],
];
