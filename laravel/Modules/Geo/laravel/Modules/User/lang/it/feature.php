<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Feature',
        'plural_label' => 'Features',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-star',
        'sort' => 75,
    ],
    'label' => 'Feature',
    'plural_label' => 'Features',
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome della feature',
            'placeholder' => 'Inserisci il nome della feature',
            'helper_text' => 'Nome identificativo della feature',
            'description' => 'Nome della feature o funzionalità',
        ],
        'guard_name' => [
            'label' => 'Guard',
            'tooltip' => 'Nome del guard',
            'placeholder' => 'Seleziona il guard',
            'helper_text' => 'Sistema di autenticazione per questa feature',
            'description' => 'Nome del guard (web, api, ecc.)',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'tooltip' => 'Permessi associati',
            'placeholder' => 'Seleziona i permessi',
            'helper_text' => 'Elenco dei permessi per questa feature',
            'description' => 'Permessi associati alla feature',
        ],
        'updated_at' => [
            'label' => 'Aggiornato il',
            'tooltip' => 'Data di ultimo aggiornamento',
            'helper_text' => 'Data dell\'ultimo aggiornamento',
            'description' => 'Timestamp dell\'ultima modifica',
        ],
        'first_name' => [
            'label' => 'Nome',
            'tooltip' => 'Nome dell\'utente',
            'placeholder' => 'Inserisci il nome',
            'helper_text' => 'Nome dell\'utente',
            'description' => 'Nome di battesimo',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'tooltip' => 'Cognome dell\'utente',
            'placeholder' => 'Inserisci il cognome',
            'helper_text' => 'Cognome dell\'utente',
            'description' => 'Cognome dell\'utente',
        ],
        'select_all' => [
            'name' => [
                'label' => 'Seleziona Tutti',
                'tooltip' => 'Seleziona tutti gli elementi',
                'helper_text' => 'Seleziona tutti gli elementi disponibili',
                'description' => 'Azione per selezionare tutto',
            ],
            'message' => [
                'label' => 'Messaggio',
                'tooltip' => 'Messaggio da mostrare',
                'placeholder' => 'Inserisci un messaggio',
                'helper_text' => 'Messaggio da visualizzare',
                'description' => 'Testo del messaggio',
            ],
            'label' => '',
            'tooltip' => '',
            'helper_text' => '',
            'description' => '',
        ],
        'value' => [
            'label' => 'Valore',
            'tooltip' => 'Valore della feature',
            'placeholder' => 'Inserisci il valore',
            'helper_text' => 'Valore associato alla feature',
            'description' => 'Valore della feature',
        ],
        'toggleColumns' => [
            'label' => 'Colonne',
            'tooltip' => 'Mostra/nascondi colonne',
            'helper_text' => 'Azione per mostrare o nascondere le colonne',
            'description' => 'Toggle per le colonne della tabella',
        ],
        'reorderRecords' => [
            'label' => 'Riordina',
            'tooltip' => 'Riordina i record',
            'helper_text' => 'Azione per riordinare i record',
            'description' => 'Funzionalità di riordinamento',
        ],
        'resetFilters' => [
            'label' => 'Reimposta Filtri',
            'tooltip' => 'Reimposta i filtri',
            'helper_text' => 'Azzera tutti i filtri attivi',
            'description' => 'Reimposta i filtri ai valori predefiniti',
        ],
        'applyFilters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri',
            'helper_text' => 'Applica i filtri selezionati',
            'description' => 'Applica i filtri alla tabella',
        ],
        'openFilters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Apri il pannello filtri',
            'helper_text' => 'Apre il pannello dei filtri',
            'description' => 'Apre il pannello dei filtri',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa',
            'tooltip' => 'Importa dati',
            'helper_text' => 'Importa dati da file esterno',
            'description' => 'Azione per importare',
            'fields' => [
                'import_file' => [
                    'label' => 'File Import',
                    'tooltip' => 'Seleziona un file da importare',
                    'placeholder' => 'Seleziona un file XLS o CSV da caricare',
                    'helper_text' => 'Seleziona un file XLS o CSV da caricare',
                    'description' => 'File contenente i dati da importare',
                ],
            ],
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta dati',
            'helper_text' => 'Esporta i dati in formato CSV/Excel',
            'description' => 'Azione per esportare',
            'filename_prefix' => [
                'label' => 'Prefisso Nome File',
                'tooltip' => 'Prefisso per il nome del file',
                'placeholder' => 'Inserisci il prefisso',
                'helper_text' => 'Prefisso per il nome del file esportato',
                'description' => 'Prefisso del nome file',
            ],
            'columns' => [
                'name' => [
                    'label' => 'Nome Colonna',
                    'tooltip' => 'Nome della colonna',
                    'helper_text' => 'Nome della colonna',
                    'description' => 'Nome della colonna',
                ],
                'parent_name' => [
                    'label' => 'Nome Padre',
                    'tooltip' => 'Nome del livello superiore',
                    'helper_text' => 'Nome del parent',
                    'description' => 'Nome del parent',
                ],
            ],
        ],
        'logout' => [
            'label' => 'Logout',
            'tooltip' => 'Disconnettiti',
            'helper_text' => 'Esci dall\'account',
            'description' => 'Azione di logout',
            'icon' => 'heroicon-o-arrow-right-on-rectangle',
        ],
    ],
    'messages' => [
        'created' => 'Feature creata con successo',
        'updated' => 'Feature aggiornata con successo',
        'deleted' => 'Feature eliminata con successo',
        'imported' => 'Importazione completata',
        'exported' => 'Esportazione completata',
    ],
];
