<?php

declare(strict_types=1);

return [
    'actions' => [
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'confirm' => 'Conferma',
        'back' => 'Indietro',
        'search' => 'Cerca',
        'filter' => 'Filtra',
        'refresh' => 'Aggiorna',
        'close' => 'Chiudi',
    ],
    'messages' => [
        'created' => ':item creato con successo',
        'updated' => ':item aggiornato con successo',
        'deleted' => ':item eliminato con successo',
        'error' => 'Si è verificato un errore',
        'confirm_delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'no_results' => 'Nessun risultato trovato',
        'loading' => 'Caricamento in corso...',
    ],
    'labels' => [
        'yes' => 'Sì',
        'no' => 'No',
        'or' => 'o',
        'by' => 'da',
        'on' => 'il',
        'from' => 'da',
        'to' => 'a',
        'in' => 'in',
        'at' => 'alle',
        'all' => 'Tutti',
    ],
    'datetime' => [
        'today' => 'Oggi',
        'yesterday' => 'Ieri',
        'tomorrow' => 'Domani',
        'now' => 'Adesso',
        'ago' => 'fa',
    ],
    'label' => 'Common',
    'plural_label' => 'Common (Plurale)',
    'navigation' => [
        'name' => 'Common',
        'plural' => 'Common',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Common',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
];
