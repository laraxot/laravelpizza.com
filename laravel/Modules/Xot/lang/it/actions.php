<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Azioni',
        'plural_label' => 'Azioni',
        'group' => 'Sistema Xot',
        'icon' => 'heroicon-o-cog',
        'sort' => 100,
        'badge' => 'Gestione azioni sistema',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Azione',
        'plural' => 'Azioni',
        'description' => 'Sistema di azioni ed operazioni del framework Xot',
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'export_xls' => [
            'label' => 'Esporta Dati',
            'icon' => 'heroicon-o-arrow-down-tray',
            'color' => 'primary',
            'tooltip' => 'Esporta i dati in formato Excel',
            'messages' => [
                'success' => 'Dati esportati con successo',
                'error' => 'Errore durante l\'esportazione',
            ],
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
        'empty_state' => 'Nessuna azione disponibile',
        'loading' => 'Caricamento azioni in corso...',
        'error_general' => 'Si è verificato un errore. Riprova più tardi.',
        'success_operation' => 'Operazione completata con successo',
    ],
    // LEGACY SUPPORT - Compatibilità con codice esistente
    'export_xls' => 'Esporta Dati',
];
