<?php

declare(strict_types=1);

return [
    'fields' => [
        'percentuale' => [
            'label' => 'Percentuale',
            'placeholder' => 'Inserisci percentuale',
            'help' => 'Percentuale del capitale',
        ],
        'anno' => [
            'label' => 'Anno',
            'placeholder' => 'Seleziona anno',
            'help' => 'Anno di riferimento',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci note',
            'help' => 'Note aggiuntive',
        ],
    ],
    'actions' => [
        'calcola' => 'Calcola',
        'applica' => 'Applica',
        'resetta' => 'Resetta',
    ],
    'messages' => [
        'calcolata' => 'Percentuale calcolata con successo',
        'applicata' => 'Percentuale applicata con successo',
        'resettata' => 'Percentuale resettata con successo',
    ],
];
