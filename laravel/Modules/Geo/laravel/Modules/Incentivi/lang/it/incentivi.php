<?php

declare(strict_types=1);

return [
    'fields' => [
        'importo' => [
            'label' => 'Importo',
            'placeholder' => 'Inserisci importo',
            'help' => 'Importo dell\'incentivo',
        ],
        'data_assegnazione' => [
            'label' => 'Data Assegnazione',
            'placeholder' => 'Seleziona data',
            'help' => 'Data di assegnazione dell\'incentivo',
        ],
        'note' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci note',
            'help' => 'Note aggiuntive',
        ],
    ],
    'actions' => [
        'assign' => 'Assegna',
        'revoke' => 'Revoca',
        'calculate' => 'Calcola',
    ],
    'messages' => [
        'assigned' => 'Incentivo assegnato con successo',
        'revoked' => 'Incentivo revocato con successo',
        'calculated' => 'Calcolo completato con successo',
    ],
];
