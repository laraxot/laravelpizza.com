<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Upload SQL',
        'group' => 'Sigma',
        'icon' => 'heroicon-o-document-text',
        'sort' => 20,
    ],
    'page' => [
        'title' => 'Upload File SQL',
        'heading' => 'Carica ed esegui file SQL',
        'description' => 'Carica file SQL e eseguili nel database specificato.',
    ],
    'fields' => [
        'db' => [
            'label' => 'Database',
            'placeholder' => 'Seleziona il database di destinazione',
            'help' => 'Il database dove verranno eseguiti i comandi SQL',
            'description' => 'Scegli il database dalla lista dei database disponibili',
            'helper_text' => 'db',
        ],
        'tbl' => [
            'label' => 'Tabella',
            'placeholder' => 'Inserisci il nome della tabella (opzionale)',
            'help' => 'Specifica una tabella specifica se il file SQL si riferisce a una tabella particolare',
            'description' => 'Lascia vuoto se il file SQL contiene comandi per più tabelle',
            'helper_text' => 'tbl',
        ],
        'attachment' => [
            'label' => 'File SQL',
            'placeholder' => 'Seleziona il file SQL da caricare',
            'help' => 'Il file SQL da eseguire nel database selezionato',
            'description' => 'Formati supportati: .sql, .txt. Dimensione massima: 10MB',
            'helper_text' => 'attachment',
        ],
    ],
    'actions' => [
        'upload' => [
            'label' => 'Carica ed Esegui',
            'icon' => 'heroicon-o-cloud-arrow-up',
            'color' => 'primary',
            'tooltip' => 'Carica il file SQL ed eseguilo nel database',
            'success' => 'File SQL caricato ed eseguito con successo',
            'error' => 'Errore durante il caricamento o l\'esecuzione del file SQL',
        ],
        'save' => [
            'label' => 'Salva',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
            'tooltip' => 'Salva le modifiche',
        ],
        'logout' => [
            'tooltip' => 'logout',
            'icon' => 'logout',
            'label' => 'logout',
        ],
        'profile' => [
            'tooltip' => 'profile',
            'icon' => 'profile',
        ],
    ],
    'messages' => [
        'upload_success' => [
            'title' => 'Upload completato',
            'body' => 'File SQL caricato ed eseguito con successo nel database: :database',
        ],
        'upload_error' => [
            'title' => 'Errore di upload',
            'body' => 'Si è verificato un errore durante il caricamento: :error',
        ],
        'execution_success' => [
            'title' => 'Esecuzione completata',
            'body' => 'Comandi SQL eseguiti con successo. Righe interessate: :affected',
        ],
        'execution_error' => [
            'title' => 'Errore di esecuzione',
            'body' => 'Errore durante l\'esecuzione dei comandi SQL: :error',
        ],
        'invalid_file' => [
            'title' => 'File non valido',
            'body' => 'Il file selezionato non è un file SQL valido',
        ],
        'file_too_large' => [
            'title' => 'File troppo grande',
            'body' => 'Il file supera la dimensione massima consentita di 10MB',
        ],
    ],
    'validation' => [
        'db_required' => 'La selezione del database è obbligatoria',
        'attachment_required' => 'Il file SQL è obbligatorio',
        'attachment_file' => 'Il file deve essere un file SQL valido',
        'attachment_max' => 'Il file non può superare i 10MB',
        'tbl_string' => 'Il nome della tabella deve essere una stringa',
    ],
];
