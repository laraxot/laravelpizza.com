<?php

declare(strict_types=1);

return [
    'update_diri_by_csv' => [ // This key represents the page itself
        'title' => 'Aggiorna DIRI da CSV',
        'description' => 'Carica un file CSV per aggiornare i dati DIRI.',
        'fields' => [
            'csvFile' => [
                'label' => 'File CSV',
                'placeholder' => 'Seleziona un file CSV',
                'help' => 'Assicurati che il file CSV sia nel formato corretto (separatore: punto e virgola).',
            ],
        ],
        'actions' => [
            'submit' => 'Processa CSV', // This corresponds to the submit action
        ],
        'notifications' => [ // New section for notifications
            'csv_processed' => 'CSV processato con successo!',
            'error' => 'Errore nel processo!',
            'csv_not_provided' => 'File CSV non fornito.',
            'failed_to_store' => 'Impossibile salvare il file caricato.',
            'path_not_provided' => 'Percorso del file CSV non fornito.',
        ],
    ],
];
