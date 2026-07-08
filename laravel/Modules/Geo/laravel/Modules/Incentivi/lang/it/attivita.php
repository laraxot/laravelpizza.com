<?php

declare(strict_types=1);

return [
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'attività',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dettagliata dell\'attività',
        ],
        'data_inizio' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di inizio dell\'attività',
        ],
        'data_fine' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di fine dell\'attività',
        ],
        'stato' => [
            'label' => 'Stato',
            'options' => [
                'da_iniziare' => 'Da Iniziare',
                'in_corso' => 'In Corso',
                'completata' => 'Completata',
                'sospesa' => 'Sospesa',
            ],
            'help' => 'Stato corrente dell\'attività',
        ],
    ],
    'actions' => [
        'avvia' => 'Avvia',
        'sospendi' => 'Sospendi',
        'completa' => 'Completa',
    ],
    'messages' => [
        'avviata' => 'Attività avviata con successo',
        'sospesa' => 'Attività sospesa con successo',
        'completata' => 'Attività completata con successo',
    ],
];
