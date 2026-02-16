<?php

declare(strict_types=1);

return [
    'actions' => [
        'export_xls' => [
            'label' => 'Esporta Excel',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Esporta i dati in formato Excel (.xlsx)',
            'placeholder' => 'Esporta in Excel',
            'help' => 'Scarica i dati correnti in formato Excel per analisi offline',
            'description' => 'Azione per esportare i dati in formato Excel',
            'success' => 'Esportazione Excel completata con successo',
            'error' => 'Si è verificato un errore durante l\'esportazione Excel',
            'modal' => [
                'heading' => 'Esporta in Excel',
                'description' => 'Seleziona le opzioni di esportazione per il file Excel',
                'confirm' => 'Esporta',
                'cancel' => 'Annulla',
            ],
            'options' => [
                'include_headers' => 'Includi intestazioni colonne',
                'format_dates' => 'Formatta date',
                'include_totals' => 'Includi totali',
            ],
        ],
    ],
];
