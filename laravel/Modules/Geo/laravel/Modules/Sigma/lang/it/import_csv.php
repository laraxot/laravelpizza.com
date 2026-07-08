<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Import CSV',
        'group' => 'Sigma',
        'icon' => 'heroicon-o-table-cells',
        'sort' => 30,
    ],
    'page' => [
        'title' => 'Importazione File CSV',
        'heading' => 'Importa dati da file CSV',
        'description' => 'Carica e importa dati da file CSV nel database.',
    ],
    'fields' => [
        'path' => [
            'label' => 'Percorso File CSV',
            'placeholder' => 'Inserisci il percorso del file CSV (es. data/import.csv)',
            'help' => 'Il percorso del file CSV da importare',
            'description' => 'Il file CSV deve essere accessibile dal sistema e contenere dati validi',
            'helper_text' => 'path',
        ],
        'delimiter' => [
            'label' => 'Delimitatore',
            'placeholder' => 'Inserisci il delimitatore (es. , ; | tab)',
            'help' => 'Il carattere utilizzato per separare i campi nel file CSV',
            'description' => 'Comuni delimitatori: virgola (,), punto e virgola (;), tab, pipe (|)',
        ],
        'encoding' => [
            'label' => 'Codifica',
            'placeholder' => 'Seleziona la codifica del file',
            'help' => 'La codifica del file CSV (es. UTF-8, ISO-8859-1)',
            'description' => 'Scegli la codifica corretta per evitare problemi con caratteri speciali',
        ],
        'has_header' => [
            'label' => 'Intestazioni',
            'help' => 'Il file CSV contiene una riga di intestazione',
            'description' => 'Seleziona se la prima riga contiene i nomi delle colonne',
        ],
        'disk' => [
            'description' => 'disk',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Importa CSV',
            'icon' => 'heroicon-o-arrow-down-tray',
            'color' => 'primary',
            'tooltip' => 'Importa i dati dal file CSV',
            'success' => 'File CSV importato con successo',
            'error' => 'Errore durante l\'importazione del file CSV',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'icon' => 'heroicon-o-eye',
            'color' => 'secondary',
            'tooltip' => 'Visualizza un\'anteprima dei dati',
        ],
    ],
    'messages' => [
        'import_success' => [
            'title' => 'Importazione completata',
            'body' => 'File CSV importato con successo. Righe importate: :count',
        ],
        'import_error' => [
            'title' => 'Errore di importazione',
            'body' => 'Si è verificato un errore durante l\'importazione: :error',
        ],
        'file_not_found' => [
            'title' => 'File non trovato',
            'body' => 'Il file CSV non è stato trovato nel percorso specificato: :path',
        ],
        'invalid_csv' => [
            'title' => 'File CSV non valido',
            'body' => 'Il file specificato non è un file CSV valido o è corrotto',
        ],
        'empty_file' => [
            'title' => 'File vuoto',
            'body' => 'Il file CSV è vuoto o non contiene dati validi',
        ],
        'preview_available' => [
            'title' => 'Anteprima disponibile',
            'body' => 'Anteprima dei primi :count righe del file CSV',
        ],
    ],
    'validation' => [
        'path_required' => 'Il percorso del file CSV è obbligatorio',
        'path_exists' => 'Il file CSV non esiste nel percorso specificato',
        'delimiter_required' => 'Il delimitatore è obbligatorio',
        'encoding_required' => 'La codifica è obbligatoria',
        'file_readable' => 'Il file CSV non è leggibile',
    ],
    'preview' => [
        'title' => 'Anteprima Dati CSV',
        'description' => 'Visualizzazione delle prime righe del file CSV',
        'columns' => 'Colonne',
        'rows' => 'Righe',
        'total_rows' => 'Totale righe nel file: :count',
    ],
];
