<?php

declare(strict_types=1);

return [
    'actions' => [
        'export_xls' => [
            'label' => 'Esporta Excel',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Esporta i dati in formato Excel (.xlsx]',
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
    'label' => 'Export Xls',
    'plural_label' => 'Export Xls (Plurale)',
    'navigation' => [
        'name' => 'Export Xls',
        'plural' => 'Export Xls',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'label' => 'Export Xls',
        'sort' => 1,
        'icon' => 'heroicon-o-collection',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],
];
