<?php

declare(strict_types=1);

return [
    'fields' => [
        'file' => [
            'label' => 'File',
            'placeholder' => 'Seleziona il file da importare',
            'help' => 'File da importare (CSV, Excel, GeoJSON, Shapefile)',
        ],
        'format' => [
            'label' => 'Formato',
            'placeholder' => 'Seleziona il formato del file',
            'help' => 'Formato del file da importare',
        ],
        'encoding' => [
            'label' => 'Codifica',
            'placeholder' => 'Seleziona la codifica',
            'help' => 'Codifica del file da importare',
        ],
        'delimiter' => [
            'label' => 'Delimitatore',
            'placeholder' => 'Inserisci il delimitatore',
            'help' => 'Delimitatore per file CSV',
        ],
        'has_headers' => [
            'label' => 'Ha intestazioni',
            'help' => 'Il file ha una riga di intestazioni',
        ],
        'skip_rows' => [
            'label' => 'Righe da saltare',
            'placeholder' => 'Inserisci il numero di righe da saltare',
            'help' => 'Numero di righe da saltare all\'inizio',
        ],
        'mapping' => [
            'label' => 'Mappatura campi',
            'placeholder' => 'Configura la mappatura dei campi',
            'help' => 'Mappatura tra campi del file e campi del database',
        ],
        'validation_rules' => [
            'label' => 'Regole di validazione',
            'placeholder' => 'Configura le regole di validazione',
            'help' => 'Regole di validazione per i dati importati',
        ],
        'update_existing' => [
            'label' => 'Aggiorna esistenti',
            'help' => 'Aggiorna i record esistenti invece di crearne di nuovi',
        ],
        'batch_size' => [
            'label' => 'Dimensione batch',
            'placeholder' => 'Inserisci la dimensione del batch',
            'help' => 'Numero di record da processare per batch',
        ],
    ],
    'validation' => [
        'file_required' => 'Il file è obbligatorio',
        'file_valid' => 'Il file deve essere valido',
        'format_required' => 'Il formato è obbligatorio',
        'encoding_required' => 'La codifica è obbligatoria',
        'mapping_required' => 'La mappatura è obbligatoria',
        'batch_size_numeric' => 'La dimensione del batch deve essere numerica',
        'batch_size_min' => 'La dimensione del batch deve essere almeno 1',
    ],
    'messages' => [
        'import_started' => 'Importazione avviata con successo',
        'import_completed' => 'Importazione completata con successo',
        'import_failed' => 'Importazione fallita',
        'import_partial' => 'Importazione completata parzialmente',
        'file_uploaded' => 'File caricato con successo',
        'file_validated' => 'File validato con successo',
        'mapping_configured' => 'Mappatura configurata con successo',
        'validation_rules_configured' => 'Regole di validazione configurate con successo',
        'import_progress' => 'Importazione in corso: :current/:total',
        'import_cancelled' => 'Importazione annullata',
    ],
    'errors' => [
        'file_not_found' => 'File non trovato',
        'file_corrupted' => 'File corrotto',
        'format_not_supported' => 'Formato non supportato',
        'encoding_not_supported' => 'Codifica non supportata',
        'mapping_invalid' => 'Mappatura non valida',
        'validation_failed' => 'Validazione fallita',
        'database_error' => 'Errore del database',
        'memory_limit_exceeded' => 'Limite di memoria superato',
        'timeout' => 'Timeout dell\'importazione',
    ],
    'formats' => [
        'csv' => 'CSV',
        'excel' => 'Excel',
        'geojson' => 'GeoJSON',
        'shapefile' => 'Shapefile',
        'kml' => 'KML',
        'gpx' => 'GPX',
    ],
    'encodings' => [
        'utf8' => 'UTF-8',
        'iso8859_1' => 'ISO-8859-1',
        'windows1252' => 'Windows-1252',
        'ascii' => 'ASCII',
    ],
    'delimiters' => [
        'comma' => 'Virgola (,)',
        'semicolon' => 'Punto e virgola (;)',
        'tab' => 'Tab',
        'pipe' => 'Pipe (|)',
        'space' => 'Spazio',
    ],
];
