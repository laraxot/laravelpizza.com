<?php

declare(strict_types=1);

return [
    'name' => 'Teams',
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del team',
            'helper_text' => 'Nome identificativo del team',
            'description' => 'Il nome che identifica questo team',
        ],
        'personal_team' => [
            'label' => 'Team Personale',
            'helper_text' => 'Indica se questo è un team personale',
            'description' => 'Un team personale è associato a un singolo utente',
        ],
        'owner' => [
            'label' => 'Proprietario',
            'helper_text' => 'Utente proprietario del team',
            'description' => 'L\'utente che ha creato e gestisce questo team',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'helper_text' => 'Data di creazione del team',
            'description' => 'Data e ora in cui è stato creato il team',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'helper_text' => 'Data dell\'ultima modifica',
            'description' => 'Data e ora dell\'ultima modifica al team',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Team',
            'tooltip' => 'Crea un nuovo team',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica i dati del team',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina il team',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza i dettagli del team',
        ],
    ],
    'messages' => [
        'success' => [
            'created' => 'Team creato con successo',
            'updated' => 'Team aggiornato con successo',
            'deleted' => 'Team eliminato con successo',
        ],
        'error' => [
            'create' => 'Errore durante la creazione del team',
            'update' => 'Errore durante l\'aggiornamento del team',
            'delete' => 'Errore durante l\'eliminazione del team',
        ],
        'confirm' => [
            'delete' => 'Sei sicuro di voler eliminare questo team?',
        ],
    ],
    'relationships' => [
        'members' => [
            'label' => 'Membri',
            'description' => 'Utenti che fanno parte di questo team',
        ],
        'owner' => [
            'label' => 'Proprietario',
            'description' => 'Utente che ha creato questo team',
        ],
    ],
    'navigation' => [],
    'label' => '',
    'plural_label' => '',
];
