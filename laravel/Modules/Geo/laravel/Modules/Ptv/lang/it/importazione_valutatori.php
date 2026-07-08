<?php

declare(strict_types=1);

return [
    'actions' => [
        'import_valutatori' => [
            'label' => 'Importa XLS',
            'success' => 'Importazione completata con successo',
            'error' => 'Si è verificato un errore durante l\'importazione',
        ],
    ],
    'fields' => [
        'file' => [
            'label' => 'File XLS',
            'help' => 'Seleziona il file XLS/XLSX da importare',
        ],
        'header_row' => [
            'label' => 'Riga intestazione',
            'help' => 'Inserisci il numero della riga che contiene le intestazioni delle colonne',
        ],
        'anno' => [
            'label' => 'Anno',
            'help' => 'Inserisci l\'anno di riferimento',
        ],
        'quadrimestre' => [
            'label' => 'Quadrimestre',
            'help' => 'Inserisci il quadrimestre di riferimento (es. 1, 2, 3, 4)',
        ],
    ],
    'notifications' => [
        'user_not_found' => 'Nessun utente trovato con email [:email]',
        'import_success' => 'Importazione completata con successo',
    ],
];
