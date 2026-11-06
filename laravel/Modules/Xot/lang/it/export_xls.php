<?php

declare(strict_types=1);

return [
    'label' => 'Esporta Excel',
    'plural_label' => 'Esporta Excel',
    'icon' => 'xot-files.xls',
    'tooltip' => 'Esporta Excel (XLS)',
    'actions' => [
        'export_xls' => [
            'label' => 'Esporta Excel',
            'icon' => 'xot-files.xls',
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
    'navigation' => [
        'label' => 'Esporta Excel',
        'name' => 'Export Xls',
        'plural' => 'Export Xls',
        'group' => [
            'name' => 'General',
            'description' => 'General Settings',
        ],
        'sort' => 1,
        'icon' => 'xot-files.xls',
    ],
    'fields' => [
        'id' => [
            'label' => 'Identificativo',
            'tooltip' => 'Identificativo univoco del record',
            'helper_text' => '',
            'description' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
    ],
];
