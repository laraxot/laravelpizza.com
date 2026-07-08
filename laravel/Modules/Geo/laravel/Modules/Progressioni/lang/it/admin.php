<?php

declare(strict_types=1);

/**
 * Traduzioni per l'amministrazione del modulo Progressioni
 */

return [
    'progressioni' => [
        'fields' => [
            'ente' => [
                'label' => 'Ente',
                'placeholder' => 'Seleziona l\'ente',
                'help' => 'Ente di appartenenza',
            ],
            'matr' => [
                'label' => 'Matricola',
                'placeholder' => 'Inserisci la matricola',
                'help' => 'Matricola del dipendente',
            ],
        ],
        'actions' => [
            'import' => [
                'label' => 'Importa dati',
                'success' => 'Dati importati con successo',
                'error' => 'Errore durante l\'importazione dei dati',
            ],
            'export' => [
                'label' => 'Esporta dati',
                'success' => 'Dati esportati con successo',
                'error' => 'Errore durante l\'esportazione dei dati',
            ],
        ],
        'messages' => [
            'welcome' => 'Benvenuto nell\'amministrazione delle progressioni',
            'no_data' => 'Nessun dato disponibile',
        ],
    ],
];
