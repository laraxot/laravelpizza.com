<?php

declare(strict_types=1);

return [
    // NAVIGATION & STRUCTURE
    'navigation' => [
        'label' => 'Dashboard',
        'plural_label' => 'Dashboard',
        'group' => 'Sistema Xot',
        'icon' => 'heroicon-o-squares-2x2',
        'sort' => 10,
        'badge' => 'Pannello di controllo principale',
        // Legacy support
        'name' => 'dashboard',
        'plural' => 'dashboard',
    ],
    // MODEL INFORMATION
    'model' => [
        'label' => 'Dashboard',
        'plural' => 'Dashboard',
        'description' => 'Pannello di controllo principale del sistema Xot',
    ],
    // FIELDS - STRUTTURA ESPANSA OBBLIGATORIA
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Nome identificativo',
            'helper_text' => 'Nome univoco per identificare l\'elemento',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'placeholder' => 'Seleziona la guardia',
            'tooltip' => 'Sistema di autenticazione',
            'helper_text' => 'Guardia utilizzata per l\'autenticazione',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'placeholder' => 'Seleziona i permessi',
            'tooltip' => 'Permessi associati',
            'helper_text' => 'Elenco dei permessi disponibili',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => 'Data ultimo aggiornamento',
            'helper_text' => 'Data e ora dell\'ultimo aggiornamento',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'tooltip' => 'Nome proprio',
            'helper_text' => 'Nome proprio della persona',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'tooltip' => 'Cognome',
            'helper_text' => 'Cognome della persona',
        ],
        'select_all' => [
            'label' => 'Seleziona Tutti',
            'tooltip' => 'Seleziona tutti gli elementi',
            'helper_text' => 'Seleziona tutti gli elementi disponibili nella lista',
        ],
    ],
    // ACTIONS - STRUTTURA ESPANSA OBBLIGATORIA
    'actions' => [
        'import' => [
            'label' => 'Importa Dati',
            'icon' => 'heroicon-o-arrow-up-tray',
            'color' => 'info',
            'tooltip' => 'Importa dati da file esterno',
            'modal' => [
                'heading' => 'Importa Dati',
                'description' => 'Seleziona un file da importare nel sistema',
                'confirm' => 'Importa',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dati importati con successo',
                'error' => 'Errore durante l\'importazione',
            ],
            'fields' => [
                'import_file' => 'Seleziona un file XLS o CSV da caricare',
            ],
        ],
        'export' => [
            'label' => 'Esporta Dati',
            'icon' => 'heroicon-o-arrow-down-tray',
            'color' => 'success',
            'tooltip' => 'Esporta dati in formato file',
            'modal' => [
                'heading' => 'Esporta Dati',
                'description' => 'Seleziona il formato di esportazione',
                'confirm' => 'Esporta',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Dati esportati con successo',
                'error' => 'Errore durante l\'esportazione',
            ],
            'filename_prefix' => 'Aree al',
            'columns' => [
                'name' => 'Nome area',
                'parent_name' => 'Nome area livello superiore',
            ],
        ],
    ],
    // SECTIONS - ORGANIZZAZIONE FORM
    'sections' => [
        'overview' => [
            'label' => 'Panoramica',
            'description' => 'Statistiche e informazioni generali',
            'icon' => 'heroicon-o-chart-bar',
        ],
        'widgets' => [
            'label' => 'Widgets',
            'description' => 'Componenti della dashboard',
            'icon' => 'heroicon-o-squares-plus',
        ],
        'resources' => [
            'label' => 'Risorse',
            'description' => 'Risorse del sistema',
            'icon' => 'heroicon-o-folder',
        ],
    ],
    // MESSAGES - FEEDBACK UTENTE
    'messages' => [
        'empty_state' => 'Nessun elemento trovato nella dashboard',
        'search_placeholder' => 'Cerca nella dashboard...',
        'loading' => 'Caricamento dashboard in corso...',
        'total_count' => 'Totale elementi: :count',
        'error_general' => 'Si è verificato un errore nella dashboard',
        'success_operation' => 'Operazione dashboard completata con successo',
    ],
    // COMPONENTS - COMPONENTI DASHBOARD
    'components' => [
        'resources' => 'Risorse',
        'pages' => 'Pagine',
        'widgets' => 'Widgets',
    ],
    // LEGACY SUPPORT - Compatibilità con codice esistente
    'resources' => 'Risorse',
    'pages' => 'Pagine',
    'widgets' => 'Widgets',
];
