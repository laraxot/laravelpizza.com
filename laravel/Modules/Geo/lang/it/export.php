<?php

declare(strict_types=1);

return [
    'fields' => [
        'format' => [
            'label' => 'Formato',
            'placeholder' => 'Seleziona il formato di esportazione',
            'help' => 'Formato del file di esportazione',
        ],
        'encoding' => [
            'label' => 'Codifica',
            'placeholder' => 'Seleziona la codifica',
            'help' => 'Codifica del file di esportazione',
        ],
        'delimiter' => [
            'label' => 'Delimitatore',
            'placeholder' => 'Seleziona il delimitatore',
            'help' => 'Delimitatore per file CSV',
        ],
        'include_headers' => [
            'label' => 'Includi intestazioni',
            'help' => 'Includi le intestazioni delle colonne',
        ],
        'fields' => [
            'label' => 'Campi',
            'placeholder' => 'Seleziona i campi da esportare',
            'help' => 'Campi da includere nell\'esportazione',
        ],
        'filters' => [
            'label' => 'Filtri',
            'placeholder' => 'Configura i filtri per l\'esportazione',
            'help' => 'Filtri da applicare ai dati da esportare',
        ],
        'sort_by' => [
            'label' => 'Ordina per',
            'placeholder' => 'Seleziona il campo di ordinamento',
            'help' => 'Campo per ordinare i dati esportati',
        ],
        'sort_direction' => [
            'label' => 'Direzione ordinamento',
            'placeholder' => 'Seleziona la direzione',
            'help' => 'Direzione dell\'ordinamento (crescente/decrescente)',
        ],
        'limit' => [
            'label' => 'Limite',
            'placeholder' => 'Inserisci il numero massimo di record',
            'help' => 'Numero massimo di record da esportare',
        ],
        'compression' => [
            'label' => 'Compressione',
            'placeholder' => 'Seleziona il tipo di compressione',
            'help' => 'Tipo di compressione per il file di esportazione',
        ],
    ],
    'validation' => [
        'format_required' => 'Il formato è obbligatorio',
        'encoding_required' => 'La codifica è obbligatoria',
        'fields_required' => 'I campi sono obbligatori',
        'limit_numeric' => 'Il limite deve essere numerico',
        'limit_min' => 'Il limite deve essere almeno 1',
    ],
    'messages' => [
        'export_started' => 'Esportazione avviata con successo',
        'export_completed' => 'Esportazione completata con successo',
        'export_failed' => 'Esportazione fallita',
        'export_cancelled' => 'Esportazione annullata',
        'file_generated' => 'File generato con successo',
        'file_downloaded' => 'File scaricato con successo',
        'filters_applied' => 'Filtri applicati con successo',
        'sorting_applied' => 'Ordinamento applicato con successo',
        'export_progress' => 'Esportazione in corso: :current/:total',
    ],
    'errors' => [
        'format_not_supported' => 'Formato non supportato',
        'encoding_not_supported' => 'Codifica non supportata',
        'fields_invalid' => 'Campi non validi',
        'filters_invalid' => 'Filtri non validi',
        'sorting_invalid' => 'Ordinamento non valido',
        'limit_invalid' => 'Limite non valido',
        'compression_failed' => 'Compressione fallita',
        'file_generation_failed' => 'Generazione file fallita',
        'download_failed' => 'Download fallito',
    ],
    'formats' => [
        'csv' => 'CSV',
        'excel' => 'Excel',
        'geojson' => 'GeoJSON',
        'shapefile' => 'Shapefile',
        'kml' => 'KML',
        'gpx' => 'GPX',
        'json' => 'JSON',
        'xml' => 'XML',
        'pdf' => 'PDF',
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
    'compression_types' => [
        'none' => 'Nessuna',
        'zip' => 'ZIP',
        'gzip' => 'GZIP',
        'tar' => 'TAR',
        '7z' => '7-Zip',
    ],
    'sort_directions' => [
        'asc' => 'Crescente',
        'desc' => 'Decrescente',
    ],
];
