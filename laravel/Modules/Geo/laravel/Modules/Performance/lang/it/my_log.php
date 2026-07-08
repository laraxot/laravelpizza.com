<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'I Miei Log',
        'plural' => 'I Miei Log',
        'group' => [
            'name' => 'Valutazione & KPI',
            'description' => 'Visualizzazione dei log personali',
        ],
        'label' => 'I Miei Log',
        'sort' => 56,
        'icon' => 'performance-log-outline',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del log',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata del log',
        ],
        'data' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona la data',
            'help' => 'Data del log',
        ],
        'tipo' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia di log',
            'options' => [
                'info' => 'Informazione',
                'warning' => 'Avviso',
                'error' => 'Errore',
            ],
        ],
        'utente' => [
            'label' => 'Utente',
            'placeholder' => 'Seleziona l\'utente',
            'help' => 'Utente associato al log',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
    ],
    'actions' => [
        'logout' => [
            'tooltip' => 'logout',
        ],
    ],
];
