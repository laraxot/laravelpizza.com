<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Web Service',
        'group' => 'Sigma',
        'icon' => 'heroicon-o-globe-alt',
        'sort' => 40,
    ],
    'page' => [
        'title' => 'Gestione Web Service',
        'heading' => 'Configurazione e gestione Web Service',
        'description' => 'Gestisci le configurazioni e le chiamate ai Web Service esterni.',
    ],
    'fields' => [
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'help' => 'Controlla la visibilità delle colonne nella tabella',
            'description' => 'Seleziona quali colonne visualizzare nella tabella dei risultati',
        ],
        'endpoint' => [
            'label' => 'Endpoint',
            'placeholder' => 'Inserisci l\'URL dell\'endpoint del Web Service',
            'help' => 'L\'URL completo dell\'endpoint del Web Service',
            'description' => 'Esempio: https://api.example.com/v1/data',
        ],
        'method' => [
            'label' => 'Metodo HTTP',
            'placeholder' => 'Seleziona il metodo HTTP',
            'help' => 'Il metodo HTTP da utilizzare per la chiamata',
            'description' => 'GET, POST, PUT, DELETE, PATCH',
        ],
        'headers' => [
            'label' => 'Headers',
            'placeholder' => 'Inserisci gli headers in formato JSON',
            'help' => 'Headers HTTP da includere nella richiesta',
            'description' => 'Formato JSON: {"Content-Type": "application/json", "Authorization": "Bearer token"}',
        ],
        'parameters' => [
            'label' => 'Parametri',
            'placeholder' => 'Inserisci i parametri in formato JSON',
            'help' => 'Parametri da inviare con la richiesta',
            'description' => 'Formato JSON per parametri di query o body',
        ],
        'timeout' => [
            'label' => 'Timeout',
            'placeholder' => 'Inserisci il timeout in secondi',
            'help' => 'Timeout per la richiesta HTTP in secondi',
            'description' => 'Valore predefinito: 30 secondi',
        ],
        'updated_at' => [
            'label' => 'updated_at',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'id' => [
            'label' => 'id',
        ],
        'name' => [
            'label' => 'name',
        ],
        'created_at' => [
            'label' => 'created_at',
        ],
    ],
    'actions' => [
        'test' => [
            'label' => 'Test Connessione',
            'icon' => 'heroicon-o-signal',
            'color' => 'info',
            'tooltip' => 'Testa la connessione al Web Service',
            'success' => 'Connessione al Web Service riuscita',
            'error' => 'Errore di connessione al Web Service',
        ],
        'call' => [
            'label' => 'Chiama Web Service',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'primary',
            'tooltip' => 'Esegui una chiamata al Web Service',
            'success' => 'Chiamata al Web Service completata',
            'error' => 'Errore durante la chiamata al Web Service',
        ],
        'save' => [
            'label' => 'Salva Configurazione',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
            'tooltip' => 'Salva la configurazione del Web Service',
        ],
        'logout' => [
            'label' => 'logout',
            'tooltip' => 'logout',
            'icon' => 'logout',
        ],
        'profile' => [
            'label' => 'profile',
            'tooltip' => 'profile',
            'icon' => 'profile',
        ],
        'create' => [
            'label' => 'create',
            'icon' => 'create',
            'tooltip' => 'create',
        ],
        'view' => [
            'label' => 'view',
            'icon' => 'view',
            'tooltip' => 'view',
        ],
        'edit' => [
            'label' => 'edit',
            'icon' => 'edit',
            'tooltip' => 'edit',
        ],
        'delete' => [
            'label' => 'delete',
            'icon' => 'delete',
            'tooltip' => 'delete',
        ],
        'layout' => [
            'label' => 'layout',
            'icon' => 'layout',
            'tooltip' => 'layout',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
            'icon' => 'applyFilters',
            'tooltip' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
            'icon' => 'openFilters',
            'tooltip' => 'openFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
            'icon' => 'resetFilters',
            'tooltip' => 'resetFilters',
        ],
        'applyTableColumnManager' => [
            'label' => 'applyTableColumnManager',
            'icon' => 'applyTableColumnManager',
            'tooltip' => 'applyTableColumnManager',
        ],
        'openColumnManager' => [
            'label' => 'openColumnManager',
            'icon' => 'openColumnManager',
            'tooltip' => 'openColumnManager',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
            'icon' => 'reorderRecords',
            'tooltip' => 'reorderRecords',
        ],
        'resetColumnManager' => [
            'label' => 'resetColumnManager',
            'icon' => 'resetColumnManager',
            'tooltip' => 'resetColumnManager',
        ],
    ],
    'messages' => [
        'connection_success' => [
            'title' => 'Connessione riuscita',
            'body' => 'Connessione al Web Service stabilita con successo',
        ],
        'connection_error' => [
            'title' => 'Errore di connessione',
            'body' => 'Impossibile connettersi al Web Service: :error',
        ],
        'call_success' => [
            'title' => 'Chiamata completata',
            'body' => 'Chiamata al Web Service completata con successo. Risposta ricevuta.',
        ],
        'call_error' => [
            'title' => 'Errore di chiamata',
            'body' => 'Errore durante la chiamata al Web Service: :error',
        ],
        'timeout_error' => [
            'title' => 'Timeout',
            'body' => 'La richiesta al Web Service ha superato il timeout di :timeout secondi',
        ],
        'invalid_response' => [
            'title' => 'Risposta non valida',
            'body' => 'Il Web Service ha restituito una risposta non valida',
        ],
        'configuration_saved' => [
            'title' => 'Configurazione salvata',
            'body' => 'La configurazione del Web Service è stata salvata con successo',
        ],
    ],
    'validation' => [
        'endpoint_required' => 'L\'endpoint è obbligatorio',
        'endpoint_url' => 'L\'endpoint deve essere un URL valido',
        'method_required' => 'Il metodo HTTP è obbligatorio',
        'method_in' => 'Il metodo HTTP deve essere uno dei seguenti: GET, POST, PUT, DELETE, PATCH',
        'headers_json' => 'Gli headers devono essere in formato JSON valido',
        'parameters_json' => 'I parametri devono essere in formato JSON valido',
        'timeout_numeric' => 'Il timeout deve essere un numero',
        'timeout_min' => 'Il timeout deve essere almeno 1 secondo',
    ],
    'response' => [
        'status' => 'Status',
        'headers' => 'Headers di Risposta',
        'body' => 'Corpo della Risposta',
        'time' => 'Tempo di Risposta',
        'size' => 'Dimensione Risposta',
        'success' => 'Successo',
        'error' => 'Errore',
        'timeout' => 'Timeout',
    ],
    'model' => [
        'label' => 'web service.model',
    ],
    'label' => 'web service',
];
