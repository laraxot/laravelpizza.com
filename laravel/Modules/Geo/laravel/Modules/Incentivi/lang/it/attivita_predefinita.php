<?php

declare(strict_types=1);

return [
    'fields' => [
        'nome' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome dell\'attività predefinita',
        ],
        'descrizione' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'Descrizione dell\'attività predefinita',
        ],
        'durata_prevista' => [
            'label' => 'Durata Prevista',
            'placeholder' => 'Inserisci durata in giorni',
            'help' => 'Durata prevista in giorni',
        ],
        'priorita' => [
            'label' => 'Priorità',
            'options' => [
                'bassa' => 'Bassa',
                'media' => 'Media',
                'alta' => 'Alta',
            ],
            'help' => 'Livello di priorità dell\'attività',
        ],
    ],
    'actions' => [
        'duplica' => 'Duplica',
        'imposta_predefinita' => 'Imposta come Predefinita',
    ],
    'messages' => [
        'duplicata' => 'Attività duplicata con successo',
        'impostata_predefinita' => 'Attività impostata come predefinita',
    ],
];
