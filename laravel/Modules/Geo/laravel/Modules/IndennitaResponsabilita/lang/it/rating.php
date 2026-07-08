<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Valutazioni',
        'plural' => 'Valutazioni',
        'group' => [
            'name' => 'Valutazioni',
            'description' => 'Sistema di valutazione del personale',
        ],
        'label' => 'Valutazioni',
        'sort' => 50,
        'icon' => 'heroicon-o-star',
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'help' => 'Identificativo univoco della valutazione',
            'tooltip' => 'ID valutazione',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Titolo',
            'placeholder' => 'Inserisci il titolo',
            'help' => 'Titolo della valutazione',
            'tooltip' => 'Titolo',
            'helper_text' => '',
        ],
        'body' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata della valutazione',
            'tooltip' => 'Corpo del testo',
            'helper_text' => '',
        ],
        'rating' => [
            'label' => 'Punteggio',
            'placeholder' => 'Inserisci il punteggio',
            'help' => 'Punteggio assegnato (1-5)',
            'tooltip' => 'Rating numerico',
            'helper_text' => '',
        ],
        'author' => [
            'label' => 'Autore',
            'placeholder' => 'Seleziona l\'autore',
            'help' => 'Chi ha effettuato la valutazione',
            'tooltip' => 'Valutatore',
            'helper_text' => '',
        ],
        'approved' => [
            'label' => 'Approvato',
            'help' => 'Indica se la valutazione è stata approvata',
            'tooltip' => 'Stato approvazione',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione della valutazione',
            'tooltip' => 'Timestamp creazione',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'help' => 'Data dell\'ultimo aggiornamento',
            'tooltip' => 'Timestamp ultimo aggiornamento',
            'helper_text' => '',
        ],
        'anno' => [
            'description' => 'anno',
            'label' => 'anno',
            'placeholder' => 'anno',
            'helper_text' => 'anno',
        ],
        'rule' => [
            'label' => 'rule',
        ],
        'is_disabled' => [
            'label' => 'is_disabled',
        ],
        'is_readonly' => [
            'label' => 'is_readonly',
        ],
        'extra_attributes' => [
            'type' => [
                'label' => 'extra_attributes.type',
            ],
            'anno' => [
                'label' => 'extra_attributes.anno',
            ],
        ],
        'filter' => [
            'label' => 'filter',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Valutazione',
            'icon' => 'heroicon-o-plus',
            'tooltip' => 'Crea una nuova valutazione',
            'success' => 'Valutazione creata con successo',
            'error' => 'Errore durante la creazione della valutazione',
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'tooltip' => 'Modifica la valutazione',
            'success' => 'Valutazione aggiornata con successo',
            'error' => 'Errore durante l\'aggiornamento',
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'tooltip' => 'Elimina la valutazione',
            'confirmation' => 'Sei sicuro di voler eliminare questa valutazione?',
            'success' => 'Valutazione eliminata con successo',
            'error' => 'Errore durante l\'eliminazione',
        ],
        'approve' => [
            'label' => 'Approva',
            'icon' => 'heroicon-o-check-badge',
            'tooltip' => 'Approva la valutazione',
            'success' => 'Valutazione approvata con successo',
            'error' => 'Errore durante l\'approvazione',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'icon' => 'heroicon-o-x-mark',
            'tooltip' => 'Rifiuta la valutazione',
            'success' => 'Valutazione rifiutata',
            'error' => 'Errore durante il rifiuto',
        ],
        'aaa' => [
            'tooltip' => 'aaa',
            'icon' => 'aaa',
            'label' => 'aaa',
        ],
        'layout' => [
            'tooltip' => 'layout',
            'icon' => 'layout',
            'label' => 'layout',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'reorderRecords' => [
            'tooltip' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'label' => 'reorderRecords',
        ],
        'openColumnManager' => [
            'tooltip' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'label' => 'openColumnManager',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
            'label' => 'profile',
        ],
        'applyTableColumnManager' => [
            'tooltip' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'label' => 'applyTableColumnManager',
        ],
        'resetFilters' => [
            'tooltip' => 'resetFilters',
            'icon' => 'resetFilters',
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'tooltip' => 'applyFilters',
            'icon' => 'applyFilters',
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'tooltip' => 'openFilters',
            'icon' => 'openFilters',
            'label' => 'openFilters',
        ],
        'view' => [
            'tooltip' => 'view',
            'icon' => 'view',
            'label' => 'view',
        ],
        'copy_from_last_year' => [
            'tooltip' => 'copy_from_last_year',
            'icon' => 'copy_from_last_year',
            'label' => 'copy_from_last_year',
        ],
    ],
    'messages' => [
        'created' => 'Valutazione creata con successo',
        'updated' => 'Valutazione aggiornata con successo',
        'deleted' => 'Valutazione eliminata con successo',
        'approved' => 'Valutazione approvata',
        'rejected' => 'Valutazione rifiutata',
        'error' => 'Si è verificato un errore',
        'validation_error' => 'Errore di validazione dei dati',
        'not_found' => 'Valutazione non trovata',
    ],
    'model' => [
        'label' => 'Valutazione',
        'plural' => 'Valutazioni',
        'description' => 'Sistema di valutazione e rating del personale',
    ],
    'label' => 'rating',
];
