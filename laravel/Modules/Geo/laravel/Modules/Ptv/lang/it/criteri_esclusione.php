<?php

declare(strict_types=1);

return [
    'types' => [
        'string' => 'Stringa',
        'int' => 'Intero',
        'date' => 'Data',
        'list' => 'Lista',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome identificativo del criterio',
        ],
        'field_name' => [
            'label' => 'Nome campo',
            'placeholder' => 'Inserisci il nome del campo',
            'help' => 'Nome del campo da valutare',
            'description' => 'field_name',
        ],
        'op' => [
            'label' => 'Operatore',
            'placeholder' => 'Seleziona operatore',
            'help' => 'Operatore di confronto',
            'options' => [
                '=' => 'Uguale a',
                '!=' => 'Diverso da',
                '>' => 'Maggiore di',
                '<' => 'Minore di',
                '>=' => 'Maggiore o uguale a',
                '<=' => 'Minore o uguale a',
                'LIKE' => 'Contiene',
                'NOT LIKE' => 'Non contiene',
            ],
            'description' => 'op',
            'helper_text' => 'op',
        ],
        'value' => [
            'label' => 'Valore',
            'placeholder' => 'Inserisci il valore',
            'help' => 'Valore di riferimento per il confronto',
            'description' => 'value',
            'helper_text' => 'value',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo',
            'help' => 'Tipo di dato da confrontare',
            'description' => 'type',
            'helper_text' => 'type',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Inserisci l\'anno',
            'help' => 'Anno di riferimento',
            'description' => 'anno',
            'helper_text' => 'anno',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea criterio esclusione',
            'success' => 'Criterio di esclusione creato con successo',
            'error' => 'Si è verificato un errore durante la creazione del criterio di esclusione',
        ],
        'edit' => [
            'label' => 'Modifica criterio esclusione',
            'success' => 'Criterio di esclusione aggiornato con successo',
            'error' => 'Si è verificato un errore durante l\'aggiornamento del criterio di esclusione',
        ],
        'delete' => [
            'label' => 'Elimina criterio esclusione',
            'success' => 'Criterio di esclusione eliminato con successo',
            'error' => 'Si è verificato un errore durante l\'eliminazione del criterio di esclusione',
            'confirm' => 'Sei sicuro di voler eliminare questo criterio di esclusione?',
        ],
    ],
    'description' => 'Gestione dei criteri di esclusione per le schede',
    'navigation' => [
        'name' => 'Criterio di Esclusione',
        'plural' => 'Criteri di Esclusione',
        'sort' => 96,
        'icon' => 'heroicon-o-x-circle',
        'group' => 'Configurazione',
        'label' => 'Criteri di Esclusione',
    ],
];
