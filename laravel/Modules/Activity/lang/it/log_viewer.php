<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icon' => 'heroicon-o-document-text',
        'group' => 'Monitoraggio',
        'label' => 'Log',
        'sort' => 64,
    ],
    'title' => 'Log di sistema',
    'tree' => [
        'heading' => 'Cartelle e file',
    ],
    'fields' => [
        'file' => 'File',
        'level' => 'Livello',
        'search' => 'Cerca nel testo',
        'window' => 'Parte da leggere',
    ],
    'placeholders' => [
        'search' => 'Cerca nelle voci mostrate...',
        'all_levels' => 'Tutti i livelli',
    ],
    'window_option' => 'Ultimi :size',
    'actions' => [
        'refresh' => [
            'label' => 'Aggiorna',
        ],
        'download' => [
            'label' => 'Scarica il file',
        ],
    ],
    'messages' => [
        'no_files' => 'Nessun file di log trovato in storage/logs.',
        'no_file_selected' => 'Scegli un file di log da consultare.',
        'file_unavailable' => 'Il file di log non è disponibile: potrebbe essere stato ruotato o rimosso. Aggiorna l\'elenco.',
        'no_entries' => 'Nessuna voce corrisponde ai filtri nella parte letta del file.',
        'summary' => 'Mostrate :shown voci su :total corrispondenti (dalla più recente).',
        'file_info' => ':size, ultima modifica :date',
        'partial_read' => 'Letti solo gli ultimi :read di :size. Ricerca e filtri valgono su questa parte: usa «Scarica il file» per averlo completo o allarga «Parte da leggere».',
        'entry_omitted' => '... :count caratteri omessi al centro: usa «Scarica il file» per il testo completo ...',
        'sensitive' => 'Attenzione: i log possono contenere dati personali (email, telefoni) e altre informazioni riservate.',
    ],
];
