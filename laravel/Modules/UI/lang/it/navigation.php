<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Navigazione',
        'plural_label' => 'Navigazioni',
        'group' => 'Gestione Contenuti',
        'icon' => 'heroicon-o-collection',
        'sort' => 1,
    ],
    'label' => 'Navigazione',
    'plural_label' => 'Navigazioni',
    'fields' => [
        'items' => [
            'label' => 'Elementi',
            'placeholder' => 'Seleziona elementi menu',
            'helper_text' => 'Elementi che compongono la navigazione',
            'description' => 'Lista degli elementi di navigazione',
            'tooltip' => 'Clicca per aggiungere elementi',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Inserisci etichetta menu',
            'helper_text' => 'Testo visualizzato nel menu',
            'description' => 'Nome dell\'elemento di navigazione',
            'tooltip' => 'Descrizione breve dell\'elemento',
        ],
        'url' => [
            'label' => 'URL',
            'placeholder' => 'Inserisci URL destinazione',
            'helper_text' => 'Indirizzo web o route name',
            'description' => 'Destinazione del link',
            'tooltip' => 'URL completo o nome route',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Navigazione',
            'success' => 'Navigazione creata con successo',
            'failure' => 'Errore nella creazione della navigazione',
        ],
        'edit' => [
            'label' => 'Modifica Navigazione',
            'success' => 'Navigazione aggiornata con successo',
            'failure' => 'Errore nell\'aggiornamento della navigazione',
        ],
        'delete' => [
            'label' => 'Elimina Navigazione',
            'success' => 'Navigazione eliminata con successo',
            'failure' => 'Errore nell\'eliminazione della navigazione',
            'confirm' => 'Sei sicuro di voler eliminare questa navigazione?',
        ],
    ],
];
