<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Fondo Performance',
        'plural' => 'Fondi Performance',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Gestione dei fondi per le performance',
        ],
        'label' => 'fondo_performance',
        'sort' => 54,
        'icon' => 'performance-review-outline',
    ],
    'fields' => [
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona l\'anno',
            'help' => 'Anno di riferimento del fondo',
        ],
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci l\'importo',
            'help' => 'Importo totale del fondo',
        ],
        'tipo' => [
            'label' => 'Tipologia',
            'placeholder' => 'Seleziona la tipologia',
            'help' => 'Tipo di fondo performance',
            'options' => [
                'organizzativo' => 'Organizzativo',
                'individuale' => 'Individuale',
                'misto' => 'Misto',
            ],
        ],
        'stato' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del fondo',
            'options' => [
                'attivo' => 'Attivo',
                'chiuso' => 'Chiuso',
                'in_revisione' => 'In Revisione',
            ],
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci eventuali note',
            'help' => 'Note aggiuntive sul fondo',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Fondo',
            'success' => 'Fondo creato con successo',
        ],
        'edit' => [
            'label' => 'Modifica',
            'success' => 'Fondo aggiornato con successo',
        ],
        'delete' => [
            'label' => 'Elimina',
            'success' => 'Fondo eliminato con successo',
        ],
        'calculate' => [
            'label' => 'Calcola Ripartizione',
            'success' => 'Ripartizione calcolata con successo',
        ],
    ],
    'messages' => [
        'validation' => [
            'importo' => [
                'required' => 'L\'importo è obbligatorio',
                'numeric' => 'L\'importo deve essere numerico',
                'min' => 'L\'importo minimo è 0',
            ],
            'anno' => [
                'required' => 'L\'anno è obbligatorio',
                'numeric' => 'L\'anno deve essere numerico',
                'min' => 'Anno non valido',
            ],
        ],
    ],
];
